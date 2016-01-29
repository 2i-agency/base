<?php

namespace Chunker\Base\Models\Traits;

trait Bounded
{
	/*
	 * Названия поля, в котором хранится позиция модели
	 */
	protected function positionField()
	{
		return property_exists($this, 'position_field') ? $this->position_field : 'position';
	}


	/*
	 * Название поля, в котором хранится ключ внешний ключ родительской модели,
	 * относительно которой происходит позиционирование
	 */
	protected function parentField()
	{
		return property_exists($this, 'parent_field') ? $this->parent_field : NULL;
	}


	/*
	 * Название поля, в котором хранится путь из ID родительских моделей.
	 * Позволяет организовывать древовидные связи между моделями одного класса
	 */
	protected function pathField()
	{
		return property_exists($this, 'path_field') ? $this->path_field : NULL;
	}


	/*
	 * Получение пути в формате массива
	 */
	public function getParentsIds()
	{
		if (!is_null($this->pathField()))
		{
			// У корневого элемента нет родителей
			if (is_null($this[$this->pathField()]))
			{
				return [];
			}
			// Конвертация пути в массив
			else
			{
				return explode('/', trim($this[$this->pathField()], '/'));
			}
		}

		return NULL;
	}


	/*
	 * Удаление дочерних элементов модели с древовидными связями
	 */
	public function deleteChildren()
	{
		if (!is_null($this->parentField()))
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
			$parentId = $this[$this->parentField()];

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


		// Формирование пути модели
		if (!is_null($this->pathField()) && !is_null($parentId))
		{
			$parents = static::find($parentId)->getParentsIds();
			array_push($parents, $parentId);
			$this[$this->pathField()] = '/' . implode('/', $parents) . '/';
		}


		// Сохранение новой позиции и других изменений
		$this[$this->positionField()] = $position;


		return $this;
	}
}