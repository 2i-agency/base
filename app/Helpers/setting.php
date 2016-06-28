<?php

/*
 * Получение значения настройки
 */

function setting($id, $default = NULL) {
	if (Schema::hasTable('options'))
	{
		$setting = \Chunker\Base\Models\Setting::find($id);
		return $setting && !empty($setting->value) ? $setting->value : $default;
	}
	else
	{
		return NULL;
	}
}