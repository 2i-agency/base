<?php

namespace Chunker\Base\Http\Controllers\Traits;

use Illuminate\Http\Request;

trait Positioning
{
	protected function setPositions(Request $request, $class) {
		$data = [];

		foreach (json_decode($request->get('ids')) as $id)
		{
			$data[] = ['id' => $id];
		}

		call_user_func([$class, 'rebuildTree'], $data);
	}
}