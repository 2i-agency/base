<?php

namespace Chunker\Base\Http\Middleware;

use Chunker\Base\Models\Redirect as Model;
use Closure;
use Illuminate\Http\Request;

class Redirect
{
	public function handle(Request $request, Closure $next) {
		if (\Schema::hasTable(with(new Model)->getTable())) {
			// Поиска правила
			$uri = Model::prepareFrom($request->fullUrl());
			$redirect = Model
				::where('from', $uri)
				->where('is_active', true)
				->first(['to']);


			// Перенаправление
			if ($redirect) {
				return redirect()->to($redirect->to);
			}
		}


		return $next($request);
	}
}