<?php

namespace Chunker\Base\Http\Controllers;

use App\Http\Controllers\Controller;

class SettingController extends Controller
{
	/*
	 * Раздел настроек
	 */
	public function getIndex($section = NULL) {
		return view('chunker.base::admin.settings.section');
	}
}