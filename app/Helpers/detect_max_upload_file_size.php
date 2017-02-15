<?php
function detect_max_upload_file_size()
{
	/**
	 * Converts shorthands like "2M" or "512K" to bytes
	 *
	 * @param int $size
	 * @return int|float
	 * @throws Exception
	 */
	$normalize = function($size) {
		if (preg_match('/^(-?[\d\.]+)(|[KMG])$/i', $size, $match)) {
			$pos = array_search($match[2], array("", "K", "M", "G"));
			$size = $match[1] * pow(1024, $pos);
		} else {
			throw new Exception("Failed to normalize memory size '{$size}' (unknown format)");
		}
		return $size;
	};
	$limits = array();
	$limits[] = $normalize(ini_get('upload_max_filesize'));
	if (($max_post = $normalize(ini_get('post_max_size'))) != 0) {
		$limits[] = $max_post;
	}
	if (($memory_limit = $normalize(ini_get('memory_limit'))) != -1) {
		$limits[] = $memory_limit;
	}
	$maxFileSize = min($limits);
	return $maxFileSize;
}