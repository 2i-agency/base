<?php

namespace Chunker\Base\Http\Controllers;

use App\Http\Controllers\Controller;
use Chunker\Base\Http\Controllers\Traits\Pagination;
use Illuminate\Http\Request;
use Chunker\Base\Models\Redirect;
use Validator;

class RedirectController extends Controller
{
	use Pagination;

	/**
	 * @var array массив правил для валидации
	 */
	protected $rules = [
		'from' => 'required|unique:base_redirects,from',
		'to'   => 'required'
	];

	/**
	 * @var array массив сообщений для валидации
	 */
	protected $messages = [
		'from.required' => 'Необходимо указать адрес страницы, с которой происходит перенаправление',
		'from.unique'   => 'Для этого адреса уже создано правило перенаправления',
		'to.required'   => 'Необходимо указать адрес, на который необходимо перенаправлять'
	];


	/**
	 * Список перенаправлений
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function index(){
		$this->authorize('redirects.view');

		$redirects = Redirect
			::orderBy('from')
			->orderBy('to')
			->withDelete()
			->paginate();

		if ($this->isNeedRedirectByPaginator($redirects)) {
			return $this->redirectByPaginator($redirects);
		} else {
			return view(
				'base::redirects.list',
				compact('redirects')
			);
		}
	}


	/**
	 * Добавление перенаправления
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(Request $request){
		$this->authorize('redirects.edit');

		/** Валидация */
		$this->validate($request, $this->rules, $this->messages);

		/** Добавление */
		$redirect = Redirect::create($request->all());

		flash()->success('Перенаправление с <b>' . $request->from . '</b> на <b>' . $redirect->to . '</b> успешно добавлено');

		return back();
	}


	/**
	 * Сохранение перенаправлений
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function save(Request $request){
		$this->authorize('redirects.edit');

		$redirects = $request->get('redirects');

		/** Валидация */
		foreach ($redirects as $redirect_id => $redirect_data) {
			/** Добавление ключа модели в правила валидации */
			$rules = $this->rules;
			$rules[ 'from' ] = $rules[ 'from' ] . ',' . $redirect_id;

			/** Подготовка поля 'Откуда' */
			$redirect_data[ 'from' ] = Redirect::prepareFrom($redirect_data[ 'from' ]);

			/** Проверка данных */
			$validator = Validator::make($redirect_data, $rules, $this->messages);

			if ($validator->fails()) {
				return back()
					->withInput()
					->withErrors($validator->errors());
			}
		}

		/** Обновление данных */
		foreach ($redirects as $redirect_id => $redirect_data) {
			Redirect
				::find($redirect_id)
				->update($redirect_data);
		}

		/** Удаление отмеченых элементов */
		if ($request->has('delete')) {
			$this->authorize('redirects.admin');
			Redirect::destroy($request->get('delete'));
		}

		flash()->success('Перенаправления сохранены');

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

		$redirect = Redirect
			::withDelete()
			->find($request->redirect);

		$this->authorize('redirects.admin', $redirect);

		$redirect->restore();

		flash()->success('Перенаправление восстановлено');

		return back();
	}
}