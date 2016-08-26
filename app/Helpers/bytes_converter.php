<?php

function byte_convert($bytes, $format = null) {
	$base = 1024;
	$units = ['B', 'KB', 'MB', 'GB', 'TB'];

	if (is_null($format)) {
		for ($i = 4; $i >= 0; $i--) {
			$size = pow($base, $i);
			if ($bytes > $size) {
				return round($bytes / $size) . ' ' . $units[$i];
			}
		}
		return $bytes . ' ' . $units[0];
	} else {
		$format = mb_strtoupper($format, 'UTF-8');
		$exp = array_search($format, $units);
		return round($bytes / pow($base, $exp)) . ' ' . $format;
	}
}