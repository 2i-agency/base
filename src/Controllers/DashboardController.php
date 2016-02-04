<?php

namespace Chunker\Base\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Chunker\Base\Models\Language;

class DashboardController extends Controller
{
	public function index()
	{
		Language::truncate();
		Language::create(['name' => 'EN', 'alias' => 'ен']);
		return view('Base::dashboard.index');
	}
}