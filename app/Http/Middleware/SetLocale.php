<?php

namespace Chunker\Base\Http\Middleware;

use Chunker\Base\Models\Language;
use App;
use Closure;
use Session;

class SetLocale
{
	public function handle($request, Closure $next)
	{
		// Определение локали по умолчанию
		if (!Session::has('admin.locale') || !Language::where('route_key', Session::get('admin.locale'))->count())
		{
			Session::set('admin.locale', Language::positioned()->first(['route_key'])->route_key);
		}

		// Переключение локали
		App::setLocale(Session::get('admin.locale'));

		// Выборка модели языка для текущей локали
		Session::set('admin.language', Language::where('route_key', Session::get('admin.locale'))->first());


		return $next($request);
	}
}