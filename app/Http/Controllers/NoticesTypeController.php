<?php

namespace Chunker\Base\Http\Controllers;

use App\Http\Controllers\Controller;
use Chunker\Base\Http\Requests\NoticesTypeRequest;
use Chunker\Base\Models\NoticesType;
use Illuminate\Http\Request;

class NoticesTypeController extends Controller
{
	/**
	 * Список типов уведомлений
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(){
		$this->authorize('notices-types.view');
		$notices_types = NoticesType::orderBy('name')->withDelete()->get();

		return view(
			'base::notices-types.list',
			compact('notices_types')
		);
	}


	/**
	 * Добавление типа уведомления
	 *
	 * @param NoticesTypeRequest $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(NoticesTypeRequest $request){
		$this->authorize('notices-types.edit');

		$notices_type = NoticesType::create($request->all());
		flash()->success('Тип уведомления <b>' . $notices_type->name . '</b> успешно добавлен');

		return back();
	}


	/**
	 * Сохранение типов уведомлений
	 *
	 * @param NoticesTypeRequest $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function save(NoticesTypeRequest $request){
		$this->authorize('notices-types.edit');

		$notices_types = $request->get('notices_types');

		/** Обновление */
		foreach ($notices_types as $notices_type_id => $notices_type_data) {
			NoticesType::find($notices_type_id)->update($notices_type_data);
		}

		/** Удаление отмеченых типов уведомлений */
		if ($request->has('delete')) {
			$this->authorize('notices-types.admin');
			NoticesType::destroy($request->get('delete'));
		}

		flash()->success('Типы уведомлений сохранены');

		return back();
	}


	/**
	 * Восстановление типов уведомлений
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restore(Request $request){

		$notices_type = NoticesType
			::withDelete()
			->find($request->notices_type);

		$this->authorize('notices-types.admin', $notices_type);

		$notices_type->restore();

		flash()->success('Тип "' . $notices_type->name . '" восстановлен');

		return back();
	}
}