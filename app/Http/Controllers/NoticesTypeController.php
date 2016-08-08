<?php

namespace Chunker\Base\Http\Controllers;

use App\Http\Controllers\Controller;
use Chunker\Base\Http\Requests\NoticesTypeRequest;
use Chunker\Base\Models\NoticesType;

class NoticesTypeController extends Controller
{
	/*
	 * Список типов уведомлений
	 */
	public function index() {
		$notices_types = NoticesType
			::orderBy('name')
			->get();

		return view('chunker.base::admin.notices-types.list', compact('notices_types'));
	}


	/*
	 * Добавление типа уведомления
	 */
	public function store(NoticesTypeRequest $request) {
		$notices_type = NoticesType::create($request->all());
		flash()->success('Тип уведомления <b>' . $notices_type->name . '</b> успешно добавлен');

		return back();
	}


	/*
	 * Сохранение уведомлений
	 */
	public function save(NoticesTypeRequest $request) {
		$notices_types = $request->get('notices_types');

		// Обновление
		foreach ($notices_types as $notices_type_id => $notices_type_data) {
			NoticesType
				::find($notices_type_id)
				->update($notices_type_data);
		}


		// Удаление
		if ($request->has('delete')) {
			NoticesType::destroy($request->get('delete'));
		}


		// Уведомление
		flash()->success('Типы уведомлений сохранены');


		return back();
	}
}