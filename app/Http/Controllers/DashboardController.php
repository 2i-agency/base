<?php

namespace Chunker\Base\Http\Controllers;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
	public function index() {
		return view('chunker.base::admin.dashboard.index');
	}
}