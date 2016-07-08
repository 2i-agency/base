<?php

namespace Chunker\Base\Http\Requests;

use App\Http\Requests\Request;

class RoleRequest extends Request
{
	public function authorize() {
		return true;
	}


	public function rules() {
		return [
			'name' => 'required'
		];
	}


	public function messages() {
		return [
			'name.required' => 'Необходимо указать название роли'
		];
	}
}