<?php

namespace Chunker\Base\Http\Requests;

use App\Http\Requests\Request;

class NoticesTypeRequest extends Request
{
	public function authorize() {
		return true;
	}


	public function rules() {
		return [
			'name' => 'sometimes|required',
			'notices_types.*.name' => 'sometimes|required'
		];
	}


	public function messages() {
		return [
			'name.required' => 'Необходимо указать название типа уведомлений',
			'notices_types.*.name.required' => 'Необходимо указать названия типов уведомлений'
		];
	}
}