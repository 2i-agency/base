<?php

namespace Chunker\Base\Http\Controllers\Traits;

use Illuminate\Http\Request;

trait Positioning
{
	protected function setPositions(Request $request, $class, $where_id = []) {
		$data = [];

		foreach (json_decode($request->get('ids')) as $id) {
			$data[] = ['id' => $id];
		}
		if (count($where_id)) {
			$class::where($where_id)->rebuildTree($data);
		} else {
			call_user_func([$class, 'rebuildTree'], $data);
		}
	}
}