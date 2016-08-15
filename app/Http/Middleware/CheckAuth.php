<?php

namespace Chunker\Base\Http\Middleware;

use Chunker\Base\Events\UserRequestedApp;
use Closure;
use Auth;

class CheckAuth
{
	public function handle($request, Closure $next) {
		// Если пользователь не авторизован
		if (Auth::guest()) {
			return $this->responses($request, 'Unauthorized', 401);
		} elseif (!Auth::user()->isAdmin()) {
			return $this->responses($request, 'Forbidden', 403);
		} else {
			// Регистрация запроса пользователя
			event(new UserRequestedApp(Auth::user()));
		}

		return $next($request);
	}


	protected function responses($request, $message, $status) {
		if ($request->ajax()) {
			// Ответ при асинхронном запросе
			return response($message, $status);
		} else {
			// Ответ при GET-запросе
			return response()->view('chunker.base::admin.auth.login', [], $status);
		}
	}
}