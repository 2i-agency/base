<?php

namespace Chunker\Base\Http\Requests;

use App\Http\Requests\Request;

class AuthenticationRequest extends Request
{
	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		return [
			'login' => 'required|exists:users',
			'password' => 'required'
		];
	}
}