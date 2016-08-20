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
			$query = $class::query();
			foreach ($where_id as $key => $value){
				$query->where([$key => $value]);
			}
			$query->rebuildTree($data);
		} else {
			call_user_func([$class, 'rebuildTree'], $data);
		}
	}
}