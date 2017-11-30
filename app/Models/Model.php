<?php

namespace Chunker\Base\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{

	protected function asJson($value) {
		return json_encode($value, JSON_UNESCAPED_UNICODE);
	}
}