<?php

namespace Chunker\Base\Http\Middleware;

use Chunker\Base\Models\Redirect;
use Closure;
use Illuminate\Http\Request;
use League\Uri\Schemes\Http;

class HandleRedirect
{
	public function handle(Request $request, Closure $next) {
		// Поиска правила
		$uri = Redirect::prepareFrom($request->fullUrl());
		$redirect = Redirect
			::where('from', $uri)
			->where('is_active', true)
			->first(['to']);


		// Перенаправление
		if ($redirect) {
			return redirect()->to($redirect->to);
		}


		return $next($request);
	}
}