<?php

function get_size($val) {
	$val = trim($val);
	$last = strtolower($val[ strlen($val) - 1 ]);
	$val = (int)$val;
	switch ($last) {
		case 'g':
			$val *= 1024;
		case 'm':
			$val *= 1024;
		case 'k':
			$val *= 1024;
	}

	return $val;
}