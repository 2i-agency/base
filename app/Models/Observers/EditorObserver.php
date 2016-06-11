<?php

namespace Chunker\Base\Models\Observers;

use Chunker\Base\Models\Traits\BelongsTo\BelongsToCreator;
use Chunker\Base\Models\Traits\BelongsTo\BelongsToUpdater;
use Chunker\Base\Models\Traits\BelongsTo\BelongsToEditors;
use Illuminate\Database\Eloquent\Model;
use Auth;

class EditorObserver
{
	protected $hasCreator;
	protected $hasUpdater;
	protected $hasEditors;


	public function __construct() {
		$this->hasCreator = BelongsToCreator::class;
		$this->hasUpdater = BelongsToUpdater::class;
		$this->hasEditors = BelongsToEditors::class;
	}


	/*
	 * Вспомогательный метод для получения массива трейтов класса
	 */
	protected function getTraits($model) {
		$reflection = new \ReflectionClass($model);
		return $reflection->getTraits();
	}


	public function creating(Model $model) {
		$this->associateCreator($model);
		$this->associateUpdater($model);
	}


	public function updating(Model $model) {
		$this->associateUpdater($model);
	}


	public function associateCreator(Model $model) {
		$traits = $this->getTraits($model);

		if (array_key_exists($this->hasEditors, $traits) || array_key_exists($this->hasCreator, $traits)) {
			$model
				->creator()
				->associate(Auth::user());
		}
	}


	public function associateUpdater(Model $model) {
		$traits = $this->getTraits($model);

		if (array_key_exists($this->hasEditors, $traits) || array_key_exists($this->hasUpdater, $traits)) {
			$model
				->updater()
				->associate(Auth::user());
		}
	}
}