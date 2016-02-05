<?php

namespace Chunker\Base\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
	public function index()
	{
		return view('Base::dashboard.index');
	}
}