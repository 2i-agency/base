<?php
/**
 * Подключает роуты, находящиеся в папке, путь до которой передан параметром
 *
 * @param string $path путь до папки с роутами
 */
function require_routes($path) {
	if (is_dir($path)) {
		$files = array_slice(scandir($path), 2);

		foreach ($files as $file) {
			require_once $path . $file;
		}
	}
}