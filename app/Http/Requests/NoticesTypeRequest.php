<?php

namespace Chunker\Base\Http\Requests;

use App\Http\Requests\Request;

/**
 * Валидация запросов на создание/редактирование типов уведомлений
 *
 * @package Chunker\Base\Http\Requests
 */
class NoticesTypeRequest extends Request
{
	/**
	 * Определяет, может ли пользователь сделать этот запрос
	 *
	 * @return bool
	 */
	public function authorize(){
		return $this->user()->can('notices-types.edit');
	}


	/**
	 * Получить правила проверки, которые применяются к запросу
	 *
	 * @return array
	 */
	public function rules(){
		return [
			'name'                 => 'sometimes|required',
			'notices_types.*.name' => 'sometimes|required'
		];
	}


	/**
	 * Получить сообщений валидации, которые применяются к запросу
	 *
	 * @return array
	 */
	public function messages(){
		return [
			'name.required'                 => 'Необходимо указать название типа уведомлений',
			'notices_types.*.name.required' => 'Необходимо указать названия типов уведомлений'
		];
	}
}