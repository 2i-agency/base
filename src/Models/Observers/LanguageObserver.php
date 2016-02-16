<?php

namespace Chunker\Base\Models\Observers;

use Chunker\Base\Helpers\Localizator;
use Illuminate\Database\Eloquent\Model;
use App;
use Storage;

class LanguageObserver
{
	protected $localizator;


	public function __construct(Localizator $localizator)
	{
		$this->localizator = $localizator;
	}


	public function creating(Model $model)
	{
		$this->makeAlias($model);
	}


	public function updating(Model $model)
	{
		$this->makeAlias($model);
	}


	/*
	 * Формирование псевдонима на основе названия
	 */
	public function makeAlias(Model $model)
	{
		$alias = trim($model->alias);
		$model->alias = mb_strlen($alias) ? $alias : $model->name;
	}
}