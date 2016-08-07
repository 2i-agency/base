<?php

namespace Chunker\Base\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Route;

trait Pagination
{
	/*
	 * Проверка необходимости дополнительного перенаправления
	 */
	protected function isNeedRedirectByPaginator(LengthAwarePaginator $paginator) {
		return $paginator->total() && !count($paginator->items());
	}


	/*
	 * Перенаправление на последнюю страницу, если на текущей нет элементов
	 */
	protected function redirectByPaginator(LengthAwarePaginator $paginator) {
		$url = Request
			::capture()
			->fullUrlWithQuery([$paginator->getPageName() => $paginator->lastPage()]);

		return redirect()->to($url);
	}
}