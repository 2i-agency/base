<?php

namespace Chunker\Admin\Middleware;

use Closure;
use Auth;

class CheckAuth
{
	public function handle($request, Closure $next)
	{
//		dd(Auth::guard());
		if (Auth::guard()->guest())
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

		return $next($request);
	}
}
