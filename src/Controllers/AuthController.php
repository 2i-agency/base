<?php

namespace Chunker\Admin\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class AuthController extends Controller
{
	/*
	 * Login user
	 */
	public function login(Request $request)
	{
		$credentials = $request->only(['login', 'password']);
		$redirect = redirect()->back();

		return Auth::attempt($credentials) ? $redirect : $redirect->withInput();
	}


	/*
	 * Logout user
	 */
	public function logout()
	{
		Auth::logout();
		return redirect()->back();
	}
}