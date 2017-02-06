<?php
namespace Chunker\Base\Models\Traits;


trait NodeTrait
{
	use \Kalnoy\Nestedset\NodeTrait;


	public function newNestedSetQuery($table = null)
	{
		$builder = $this->newQuery();

		if ($this->usesSoftDelete()) {
			$builder =  method_exists($builder, 'withDelete')
				? $builder->withDelete()
				: $builder->withTrashed();
		}

		return $this->applyNestedSetScope($builder, $table);
	}
}