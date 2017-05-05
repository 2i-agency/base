<?php

namespace Chunker\Base\Models\Traits;

use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

trait ActivityLog
{
	use LogsActivity;


	public function getLogs($method = 'get') {
		return Activity
			::where('subject_type', self::class)
			->where('subject_id', $this->id)
			->orderBy('created_at', 'desc')
			->$method();
	}


	public function getLog($log = NULL) {
		if (isset($log)) {
			return Activity::find($log instanceof Activity ? $log->id : $log);
		}

		return NULL;
	}


	/**
	 * Возвращает список атрибутов для записи изменений в лог.
	 * Переопределил метод в трейте LogsActivity
	 */
	public function attributesToBeLogged():array {
		if (!config('chunker.admin.logging') || !isset(static::$logAttributes)) {
			return [];
		}

		return static::$logAttributes;
	}
}