<?php

namespace Chunker\Base\Http\Controllers\Traits;

use Illuminate\Http\Request;

/**
 * Методы для работы с позиционированием элементов в списке
 *
 * @package Chunker\Base\Http\Controllers\Traits
 */
trait Positioning
{
	/**
	 * Обновление позиций элементов в списке.
	 * Требует пакет: "kalnoy/nestedset"
	 *
	 * @param Request $request
	 * @param mixed   $class класс модели, к которой относятся элементы
	 */
	protected function setPositions(Request $request, $class){
		$moved = $class::find($request->get('moved'));

		if ($request->has('prev')) {
			$moved->insertAfterNode(
				$class::find($request->get('prev'))
			);
		} elseif ($request->has('next')) {
			$moved->insertBeforeNode(
				$class::find($request->get('next'))
			);
		}
	}
}