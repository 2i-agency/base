<?php

namespace Chunker\Base\Models\Traits;

use Illuminate\Database\Eloquent\Collection;

// TODO разделить трейт на два: для позиционироввания и древовидной связи
// TODO перенести методы-отношения `parent` и `children` в трейт
trait Bounded
{
	/*
	 * Названия поля, в котором хранится позиция модели
	 */
	protected function positionField()
	{
		return property_exists($this, 'positionField') ? $this->positionField : 'position';
	}


	/*
	 * Название поля, в котором хранится внешний ключ родительской модели,
	 * относительно которой происходит позиционирование
	 */
	protected function parentField()
	{
		return property_exists($this, 'parentField') ? $this->parentField : NULL;
	}


	/*
	 * Названия полей, в которых хранятся внешние ключи второстепенных родительских моделей
	 */
	protected function secondaryParentsFields()
	{
		return property_exists($this, 'secondaryParentsFields') ? $this->secondaryParentsFields : NULL;
	}


	/*
	 * Получение коллекции родительских моделей при древовидной связи
	 */
	public function getParents()
	{
		$parents = new Collection();

		if ($this->hasTreeBounding && !is_null($this->parentField()))
		{
			$model = $this;

			while ($model[$this->parentField()])
			{
				$id = $model[$this->parentField()];
				$model = static::findOrNew($id);
				$parents->push($model);
			}

			$parents = $parents->reverse();
		}


		return $parents;
	}


	/*
	 * Получение массива ключей потомков при древовидной связи
	 */
	public function getChildrenIds()
	{
		return $this->fillChildrenIds($this);
	}


	/*
	 * Наполнение массив ключами потомков при древовидной связи
	 */
	protected function fillChildrenIds($parent)
	{
		$ids = [];

		if ($this->hasTreeBounding && !is_null($this->parentField()))
		{
			// Запрос ключей дочерних моделей
			$children = static
				::where($this->parentField(), $parent->getKey())
				->get([$this->getKeyName()]);

			// Наполнение массива
			foreach ($children as $child)
			{
				$grandchildren_ids = $this->fillChildrenIds($child);

				// Если есть внучатые модели, то добавляются ключи потомков
				if (count($grandchildren_ids))
				{
					$ids = array_merge($ids, $grandchildren_ids);
				}
				// Если дочерняя модель не имеет своих потомков, до добавляется её ключ
				else
				{
					$ids[] = $child->id;
				}
			}
		}


		return $ids;
	}


	/*
	 * Удаление дочерних элементов модели с древовидными связями
	 */
	public function deleteChildren()
	{
		if ($this->hasTreeBounding && !is_null($this->parentField()))
		{
			$children = static::where($this->parentField(), $this->id)->get();

			foreach ($children as $child)
			{
				$child->delete();
			}
		}


		return $this;
	}


	/*
	 * Сортировка по позиции
	 */
	public function scopePositioned($query)
	{
		return $query->orderBy($this->positionField());
	}


	/*
	 * Уменьшение позиций соседей по стеку после текущей позиции модели
	 */
	public function pullSiblings()
	{
		$this
			->filterByParents()
			->where($this->positionField(), '>=', $this[$this->positionField()])
			->decrement($this->positionField());

		return $this;
	}


	/*
	 * Позиционирование модели в стеке
	 */
	public function placeTo($position)
	{
		// Уменьшение позиций соседей после текущей позиции,
		// чтобы заполнить пробел, который появится после обновления
		$this->pullSiblings();


		// Увеличение позиций соседей после новой позиции,
		// чтобы создать пробел, который требуется для позиционирования модели
		$this
			->filterByParents()
			->where($this->positionField(), '>=', $position)
			->increment($this->positionField());

		// Обновление позиции модели
		$this[$this->positionField()] = $position;
		$this->save();


		return $this;
	}


	/*
	 * Позиционирование в конце стека
	 */
	public function placeToEnd($parentId = NULL)
	{
		// Если модель уже спозиционирована,
		// то её соседей после текущей позиции
		// нужно сдвинуть к началу
		if ($this[$this->positionField()])
		{
			$this->pullSiblings();
		}


		// Если новый родитель не указывается,
		// то модель помещается в конец текущего стека
		if (is_null($parentId))
		{
			$position = $this
				->filterByParents()
				->max($this->positionField()) + 1;
		}
		// Перемещение модели к новому родителю
		else
		{
			// Расчёт новой позиции
			$position = static
				::where($this->parentField(), $parentId)
				->max($this->positionField()) + 1;

			// Привязка к новому родителю
			$this[$this->parentField()] = $parentId;
		}


		// Сохранение новой позиции и других изменений
		$this[$this->positionField()] = $position;


		return $this;
	}


	/*
	 * Фильтрацией по внешним родительским ключам
	 */
	public function scopeFilterByParents($query)
	{
		// Фильтрация моделей для отсева тех, которые не являются соседями по стеку...
		if (!is_null($this->parentField()))
		{
			$query = $query->where($this->parentField(), $this[$this->parentField()]);
		}

		// ...и доплнительным родителям
		if (!is_null($secondaries = $this->secondaryParentsFields()))
		{
			foreach ($secondaries as $secondary)
			{
				$query = $query->where($secondary, $this[$secondary]);
			}
		}


		return $query;
	}
}