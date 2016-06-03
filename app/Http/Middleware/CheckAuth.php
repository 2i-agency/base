<?php

namespace Chunker\Base\Http\Middleware;

use Chunker\Base\Events\UserRequestedApp;
use Closure;
use Auth;

class CheckAuth
{
	public function handle($request, Closure $next)
	{
		// Если пользователь не авторизован
		if (Auth::guest())
		{
			// Ответ при асинхронном запросе
			if ($request->ajax())
			{
				return response('Unauthorized.', 401);
			}
			// Ответ при GET-запросе
			else
			{
				return response()->view('chunker.base::auth.login', [], 401);
			}
		}
		// Регистрация запроса пользователя
		else
		{
			event(new UserRequestedApp(Auth::user()));
		}

		return $next($request);
	}
}