<?php

/*
 * Получение значения настройки
 */

function setting($id, $default = NULL) {
	$setting = \Chunker\Base\Models\Setting::find($id);
	return $setting && !empty($setting->value) ? $setting->value : $default;
}