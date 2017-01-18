<?php

/**
 * Отбрасываем расширения из имени файла
 *
 * @param string $name имя файла
 * @param bool   $last указывает, отбрасывать все расширения или только последнее
 *
 * @return string
 */
function drop_extension(string $name, $last = false):string {
	if ($last) {
		$first_extension = array_last(explode('.', $name));

		return implode('.', array_diff(explode('.', $name), [ $first_extension ]));
	} else {
		return array_first(explode('.', $name));
	}
}