<?php

namespace Chunker\Base\Http\Requests;

use App\Http\Requests\Request;

/**
 * Валидация запросов на аутентификацию
 *
 * @package Chunker\Base\Http\Requests
 */
class AuthenticationRequest extends Request
{
	/**
	 * Определяет, может ли пользователь сделать этот запрос
	 *
	 * @return bool
	 */
	public function authorize(){
		return true;
	}

	/**
	 * Получить правила проверки, которые применяются к запросу
	 *
	 * @return array
	 */
	public function rules(){
		return [
			'login'    => 'required|exists:base_users',
			'password' => 'required'
		];
	}
}