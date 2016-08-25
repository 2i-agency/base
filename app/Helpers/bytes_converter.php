<?php

function byte_convert($bytes, $format = '') {
	$sizes = [
		'TB' => (1000 * 1000 * 1000 * 1000),
		'GB' => (1000 * 1000 * 1000),
		'MB' => (1000 * 1000),
		'KB' => 1000,
		'B' => 1
	];

	if ($format == '') {
		foreach ($sizes as $name => $size) {
			if ($bytes > $size) {
				return round($bytes / $size) . $name;
			}
		}
	}
	else {
		return round($bytes / $sizes[$format]) . $format;
	}

}