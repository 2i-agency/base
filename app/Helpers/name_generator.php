<?php

/*
 * Создание случайного имени. Алгоритм взят из пакета Base.
 */
function make_random_name($definition = NULL) {
	$name = time() . '-' . md5(rand(0, 999999999999));

	if (!is_null($definition)) {
		$extension = mb_strtolower($definition);
		preg_match('/[\w]+$/', $extension, $extension);
		$extension = $extension[0];
		$name .= '.' . $extension;
	}

	return $name;
}