<?php

namespace Chunker\Base\Controllers;

use Chunker\Base\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
	public function index()
	{
		$all_users = User::orderBy('login');
		$active_users = $all_users->get();
		$deleted_users = $all_users->onlyTrashed()->get();

		return view('Base::users.index', compact('active_users', 'deleted_users'));
	}
}