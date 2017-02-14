<?php

namespace Chunker\Base\Http\Middleware;

use Chunker\Base\Models\Language;
use App;
use Closure;

/**
 * Посредник для установки локали
 *
 * @package Chunker\Base\Http\Middleware
 */
class SetLocale
{
	public function handle($request, Closure $next){
		/** Определение локали по умолчанию */
		if (
			!session()->has('admin.locale')
			|| !Language::where('locale', session()->get('admin.locale'))->count()
		) {
			$language = Language::defaultOrder()->first();

			if (!is_null($language)) {
				session([
					'admin.locale'   => $language->locale,
					'admin.language' => $language
				]);
			}
		}

		return $next($request);
	}
}