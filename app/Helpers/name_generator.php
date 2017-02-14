<?php

/**
 * Создание случайного имени для файлов
 *
 * @param string $definition
 *
 * @return string
 */
function name_generator($definition = NULL){
	$name = time() . '-' . md5(rand(0, 999999999999));

	if (!is_null($definition)) {
		$extension = mb_strtolower($definition);
		preg_match('/[\w]+$/', $extension, $extension);
		$extension = $extension[ 0 ];
		$name .= '.' . $extension;
	}

	return $name;
}