<?php

namespace Chunker\Base\Models\Traits;

use Illuminate\Database\Eloquent\Model;

trait Positioned
{
	/*
	 * Order by position
	 */
	public function scopePositioned($query)
	{
		return $query->orderBy($this->positionField());
	}


	/*
	 * Getting parents
	 */
	public function getParentsIds()
	{
		// No parents
		if (!is_null($this->parentsField()))
		{
			// This is in root
			if (is_null($this[$this->parentsField()]))
			{
				return [];
			}
			// Converting to array
			else
			{
				return explode('/', trim($this[$this->parentsField()], '/'));
			}
		}

		return NULL;
	}


	/*
	 * Delete children
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
	 * Pulling siblings after element on one position to forward
	 */
	public function pullSiblings()
	{
		// Selecting next siblings
		$query = static::where($this->positionField(), '>', $this[$this->positionField()]);

		// Filtering by parent
		if (!is_null($this->parentField()))
		{
			$query = $query->where($this->parentField(), $this[$this->parentField()]);
		}

		// Pulling
		$query->decrement($this->positionField());

		return $this;
	}


	/*
	 * Setting model position
	 */
	public function placeTo($position)
	{
		$this
			->pullSiblings()
			[$this->positionField()] = $position;

		// Selecting siblings after new position
		$query = static::where($this->positionField(), '>=', $this[$this->positionField()]);

		// Filtering by parent
		if (!is_null($this->parentField()))
		{
			$query = $query->where($this->parentField(), $this[$this->parentField()]);
		}

		// Pushing next siblings
		$query->increment($this->positionField());

		$this->save();
	}


	/*
	 * Append model to the end of owner's children
	 */
	public function placeToEnd($parentId = NULL)
	{
		if (is_null($this->parentField()))
		{
			$new_position = static::max($this->positionField()) + 1;
		}
		else
		{
			$parentId = is_null($parentId) ? $this[$this->parentField()] : $parentId;

			// Calculating position in new parent
			$new_position = static::where($this->parentField(), $parentId)
				->max($this->positionField()) + 1;

			// Setting model parent
			$this[$this->parentField()] = $parentId;

			// Updating parents path
			if (!is_null($this->parentsField()) && !is_null($parentId))
			{
				$parents = static::find($parentId)->getParentsIds();
				array_push($parents, $parentId);
				$this->parents = '/' . implode('/', $parents) . '/';
			}
		}

		// Setting model position
		$this[$this->positionField()] = $new_position;


		return $this;
	}


	/*
	 * Getting position field name
	 */
	protected function positionField()
	{
		return property_exists($this, 'position_field') ? $this->position_field : 'position';
	}


	/*
	 * Getting position parent field name
	 */
	protected function parentField()
	{
		return property_exists($this, 'parent_field') ? $this->parent_field : NULL;
	}


	/*
	 * Getting parents field name
	 */
	protected function parentsField()
	{
		return property_exists($this, 'parents_field') ? $this->parents_field : NULL;
	}
}