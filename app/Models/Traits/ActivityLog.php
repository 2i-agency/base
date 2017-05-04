<?php

namespace Chunker\Base\Models\Traits;

use Spatie\Activitylog\Traits\LogsActivity;

trait ActivityLog
{
	use LogsActivity;


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