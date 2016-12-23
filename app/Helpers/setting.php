<?php

/**
 * Получение значения настройки
 *
 * @param      $id
 * @param      $default = null
 *
 * @return null
 */
function setting($id, $default = NULL){
	if (Schema::hasTable('settings')) {
		$setting = \Chunker\Base\Models\Setting::find($id);

		return $setting && !empty($setting->value) ? $setting->value : $default;
	} else {
		return NULL;
	}
}