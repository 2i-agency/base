<?php

function get_max_filesize() {
	$post_max_size = ini_get('post_max_size');
	$upload_max_filesize = ini_get('upload_max_filesize');
	$memory_limit = ini_get('memory_limit');

	$max_size = get_size($post_max_size);
	$upload_max_filesize = get_size($upload_max_filesize);
	$memory_limit = get_size($memory_limit);

	if ($upload_max_filesize < $max_size) {
		$max_size = $upload_max_filesize;
	}

	if ($memory_limit < $max_size) {
		$max_size = $memory_limit;
	}

	return $max_size;

}