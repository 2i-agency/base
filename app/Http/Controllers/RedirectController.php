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

	protected $rules = [
		'from'  => 'required|unique:base_redirects,from',
		'to'    => 'required'
	];

	protected $messages = [
		'from.required'  => 'Необходимо указать адрес страницы, с которой происходит перенаправление',
		'from.unique'   => 'Для этого адреса уже создано правило перенаправления',
		'to.required'   => 'Необходимо указать адрес, на который необходимо перенаправлять'
	];


	/*
	 * Список перенаправлений
	 */
	public function index() {
		$redirects = Redirect
			::orderBy('from')
			->orderBy('to')
			->paginate(3);

		if ($this->isNeedRedirectByPaginator($redirects)) {
			return $this->redirectByPaginator($redirects);
		} else {
			return view('chunker.base::admin.redirects.list', compact('redirects'));
		}
	}


	/*
	 * Добавление перенаправления
	 */
	public function store(Request $request) {
		// Валидация
		$this->validate($request, $this->rules, $this->messages);

		// Добавление
		$redirect = Redirect::create($request->all());

		// Уведомление
		flash()->success('Перенаправление с <b>' . $request->from . '</b> на <b>' . $redirect->to . '</b> успешно добавлено');


		return back();
	}


	/*
	 * Сохранение перенаправлений
	 */
	public function save(Request $request) {
		$redirects = $request->get('redirects');


		// Валидация
		foreach ($redirects as $redirect_id => $redirect_data) {
			// Добавление ключа модели в правила валидации
			$rules = $this->rules;
			$rules['from'] = $rules['from'] . ',' . $redirect_id;

			// Подготовка `Откуда`
			$redirect_data['from'] = Redirect::prepareFrom($redirect_data['from']);

			// Проверка данных
			$validator = Validator::make($redirect_data, $rules, $this->messages);

			if ($validator->fails()) {
				return back()
					->withInput()
					->withErrors($validator->errors());
			}
		}


		// Обновление
		foreach ($redirects as $redirect_id => $redirect_data) {
			Redirect
				::find($redirect_id)
				->update($redirect_data);
		}


		// Удаление
		if ($request->has('delete')) {
			Redirect::destroy($request->get('delete'));
		}


		// Уведомление
		flash()->success('Перенаправления сохранены');


		return back();
	}
}