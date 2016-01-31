<?php

namespace Chunker\Base\Models\Traits;

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
	 * Название поля, в котором хранится ключ внешний ключ родительской модели,
	 * относительно которой происходит позиционирование
	 */
	protected function parentField()
	{
		return property_exists($this, 'parentField') ? $this->parentField : NULL;
	}


	/*
	 * Получение ключей родительских моделей при древовидной связи
	 */
	public function getParentsIds()
	{
		$ids = [];

		if ($this->hasTreeBounding && !is_null($this->parentField()))
		{
			$model = $this;

			while ($model[$this->parentField()])
			{
				$ids[] = $model[$this->parentField()];
				$model = static::findOrNew($model[$this->parentField()]);
			}
		}


		return array_reverse($ids);
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
		// Выборка соседей
		$query = static::where($this->positionField(), '>=', $this[$this->positionField()]);

		// Если позиционирование происходит относительно родителя,
		// то необходима дополнительная фильтрация по его ID,
		// чтобы остались только соседи
		if (!is_null($this->parentField()))
		{
			$query = $query->where($this->parentField(), $this[$this->parentField()]);
		}

		// Сдвиг
		$query->decrement($this->positionField());


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


		// Выборка моделей после новой позиции
		$query = static::where($this->positionField(), '>=', $position);

		// Дополнительная фильтрация моделей для отсева тех,
		// которые не являются соседями по стеку
		if (!is_null($this->parentField()))
		{
			$query = $query->where($this->parentField(), $this[$this->parentField()]);
		}

		// Увеличение позиций соседей после новой позиции,
		// чтобы создать пробел, который требуется для позиционирования модели
		$query->increment($this->positionField());

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
			// Расчёт новой позиции
			if (is_null($this->parentField()))
			{
				$position = static::max($this->positionField()) + 1;
			}
			else
			{
				$position = static::where($this->parentField(), $this[$this->parentField()])
					->max($this->positionField()) + 1;
			}
		}
		// Перемещение модели к новому родителю
		else
		{
			// Расчёт новой позиции
			$position = static::where($this->parentField(), $parentId)
				->max($this->positionField()) + 1;

			// Привязка к новому родителю
			$this[$this->parentField()] = $parentId;
		}


		// Сохранение новой позиции и других изменений
		$this[$this->positionField()] = $position;


		return $this;
	}
}