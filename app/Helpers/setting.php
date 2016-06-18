<?php

/*
 * Получение значения настройки
 */
function setting($id, $default = NULL) {
	return \Chunker\Base\Models\Setting::find($id)->value ?: $default;
}