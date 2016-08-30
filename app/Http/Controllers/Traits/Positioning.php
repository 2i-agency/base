<?php

namespace Chunker\Base\Http\Controllers\Traits;

use Illuminate\Http\Request;

trait Positioning
{
	protected function setPositions(Request $request, $class) {
		$moved = $class::find($request->get('moved'));

		if ($request->has('prev')) {
			$moved->insertAfterNode($class::find($request->get('prev')));
		} else if ($request->has('next')) {
			$moved->insertBeforeNode($class::find($request->get('next')));
		}
	}
}