<?php

/*
 * Получение название размера флага
 */

function get_flag_locale($size) {
	if (isset($size)) {
		return config('chunker.localization.flag.view.' . $size, '');
	}
}


/*
 * Проверка включения флага
 */

function flag_is_active() {
		return (bool)config('chunker.localization.flag', FALSE);
}