<?php

namespace Chunker\Base\Http\Controllers\Traits;

use Illuminate\Pagination\LengthAwarePaginator;
use Route;

/**
 * Методы для правильного перехода по пагинации при удалении элементов
 *
 * @package Chunker\Base\Http\Controllers\Traits
 */
trait Pagination
{
	/**
	 * Проверка необходимости дополнительного перенаправления
	 *
	 * @param LengthAwarePaginator $paginator
	 *
	 * @return bool
	 */
	protected function isNeedRedirectByPaginator(LengthAwarePaginator $paginator){
		return $paginator->total() && !count($paginator->items());
	}


	/**
	 * Перенаправление на последнюю страницу, если на текущей нет элементов
	 *
	 * @param LengthAwarePaginator $paginator
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function redirectByPaginator(LengthAwarePaginator $paginator){
		$url = request()->fullUrlWithQuery([ $paginator->getPageName() => $paginator->lastPage() ]);

		return redirect()->to($url);
	}
}