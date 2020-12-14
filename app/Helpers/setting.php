<?php

/**
 * Получение значения настройки
 *
 * @param      $id
 * @param      $default
 *
 * @return null|string
 */
function setting($id, $default = NULL){
	if (Schema::hasTable('base_settings')) {
		$setting = \Chunker\Base\Models\Setting::find($id);

		return $setting && !empty($setting->value) ? $setting->value : $default;
	} else {
		return NULL;
	}
}