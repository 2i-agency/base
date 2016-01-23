<?php

namespace Chunker\Base\Models\Observers;

use Chunker\Base\Models\Traits\HasCreator;
use Chunker\Base\Models\Traits\HasUpdater;
use Chunker\Base\Models\Traits\HasEditors;
use Illuminate\Database\Eloquent\Model;
use Auth;

class EditorObserver
{
	protected $hasCreator;
	protected $hasUpdater;
	protected $hasEditors;


	public function __construct()
	{
		$this->hasCreator = HasCreator::class;
		$this->hasUpdater = HasUpdater::class;
		$this->hasEditors = HasEditors::class;
	}


	/*
	 * Shorthand to traits list of model
	 */
	protected function getTraits($model)
	{
		$reflection = new \ReflectionClass($model);
		return $reflection->getTraits();
	}


	/*
	 * Then model is creating
	 */
	public function creating(Model $model)
	{
		$this->associateCreator($model);
		$this->associateUpdater($model);
	}


	/*
	 * Then model is updating
	 */
	public function updating(Model $model)
	{
		$this->associateUpdater($model);
	}


	/*
	 * Associate with creator
	 */
	public function associateCreator(Model $model)
	{
		$traits = $this->getTraits($model);

		if (array_key_exists($this->hasEditors, $traits) || array_key_exists($this->hasCreator, $traits))
		{
			$model
				->creator()
				->associate(Auth::user());
		}
	}


	/*
	 * Associate with updater
	 */
	public function associateUpdater(Model $model)
	{
		$traits = $this->getTraits($model);

		if (array_key_exists($this->hasEditors, $traits) || array_key_exists($this->hasUpdater, $traits))
		{
			$model
				->updater()
				->associate(Auth::user());
		}
	}
}