<?php

namespace Chunker\Base\Http\Controllers;

use Chunker\Base\Events\UserLoggedIn;
use Chunker\Base\Events\UserRequestedApp;
use Chunker\Base\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class AuthController extends Controller
{
	/*
	 * Аутентификация
	 */
	public function login(Request $request) {
		$credentials = $request->only(['login', 'password']);

		// Успешная аутентификация
		if (Auth::attempt($credentials)) {
			event(new UserLoggedIn(Auth::user(), false));
			return redirect()->back();
		}

		// Аутентификация провалена
		else {
			$user = User::where('login', $credentials['login'])->first();

			if ($user) {
				event(new UserLoggedIn($user, true));
			}

			return redirect()->back()->withInput();
		}
	}


	/*
	 * Деаутентификация
	 */
	public function logout() {
		event(new UserRequestedApp(Auth::user()));
		Auth::logout();

		return redirect()->back();
	}
}