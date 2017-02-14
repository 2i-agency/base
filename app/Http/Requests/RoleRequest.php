<?php

namespace Chunker\Base\Http\Requests;

use App\Http\Requests\Request;

/**
 * Валидация запросов на создание/редактирование ролей
 *
 * @package Chunker\Base\Http\Requests
 */
class RoleRequest extends Request
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
			'name' => 'required'
		];
	}


	/**
	 * Получить сообщений валидации, которые применяются к запросу
	 *
	 * @return array
	 */
	public function messages(){
		return [
			'name.required' => 'Необходимо указать название роли'
		];
	}
}