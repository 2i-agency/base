<?php

namespace Chunker\Base\Http\Controllers;

use Chunker\Base\Events\UserLoggedIn;
use Chunker\Base\Events\UserRequestedApp;
use Chunker\Base\Models\User;
use Chunker\Base\Http\Requests\AuthenticationRequest;
use App\Http\Controllers\Controller;
use Auth;

class AuthController extends Controller
{
	/*
	 * Аутентификация
	 */
	public function login(AuthenticationRequest $request) {
		$credentials = $request->only(['login', 'password']);

		// Успешная аутентификация
		if (Auth::attempt($credentials, $request->has('remember'))) {
			event(new UserLoggedIn(Auth::user(), false));
			return redirect()->back();
		}
		// Аутентификация провалена
		else {
			$user = User::where('login', $credentials['login'])->first();
			event(new UserLoggedIn($user, true));
			flash()->error('Указан неверный пароль');

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