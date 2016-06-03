<?php

namespace Chunker\Base\Middleware;

use Chunker\Base\Models\Language;
use App;
use Closure;
use Session;

class SetLocale
{
	public function handle($request, Closure $next)
	{
		// Определение локали по умолчанию
		if (!Session::has('admin.locale') || !Language::where('alias', Session::get('admin.locale'))->count())
		{
			Session::set('admin.locale', Language::positioned()->first(['alias'])->alias);
		}

		// Переключение локали
		App::setLocale(Session::get('admin.locale'));

		// Выборка модели языка для текущей локали
		Session::set('admin.language', Language::where('alias', Session::get('admin.locale'))->first());


		return $next($request);
	}
}