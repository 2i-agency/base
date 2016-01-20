<?php

namespace Chunker\Admin\Middleware;

use Chunker\Admin\Events\UserRequestedApp;
use Closure;
use Auth;

class CheckAuth
{
	public function handle($request, Closure $next)
	{
		if (Auth::guest())
		{
			if ($request->ajax())
			{
				return response('Unauthorized.', 401);
			}
			else
			{
				return response()->view('Admin::auth.login', [], 401);
			}
		}
		else
		{
			event(new UserRequestedApp(Auth::user()));
		}

		return $next($request);
	}
}
