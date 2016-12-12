<?php

namespace Chunker\Base\Http\Controllers\Traits;

use Illuminate\Http\Request;
use App\Http\Requests;

trait Directory
{
	use Positioning;

	function getQueryFromModel($id) {
		$model = new $this->model;

		$route_key_name = $model->getRouteKeyName();

		return $model->where($route_key_name, $id);
	}

	/*
	 * Отображение
	 */
	function index() {
		$this->authorize($this->abilities['view']);

		$model = $this->model;
		$view = is_string($this->view) ? $this->view : $this->view['index'];

		return view($view, [
			'directory' => $model::defaultOrder()->get()
		]);
	}


	/*
	 * Добавление
	 */
	function store(Request $request) {
		$this->authorize($this->abilities['edit']);
		$this->validate($request, $this->rules, $this->validateMessages);

		$model = $this->model;
		$model::create($request->all());

		flash()->success($this->flashMessages['store']);
		return back();
	}


	/*
	 * Обновление списка
	 */
	function save(Request $request) {
		$this->authorize($this->abilities['edit']);

		$key_delete = isset($request->delete) ? array_keys($request->delete) : [];
		$model = $this->model;
		$names = $request->names;

		foreach ($key_delete as $id) {
			$model::find($id)->delete();
		}

		foreach ($names as $id => $name) {
			$is_delete = array_search($id, $key_delete);
			$rule = isset($this->rules['names.*']) ? $this->rules['names.*'] . $id : '';

			if (is_bool($is_delete)) {
				$this->validate(
					$request,
					['names.*' => $rule],
					$this->validateMessages);
				$model::find($id)->update(['name' => $name]);
			}

		}

		flash()->success($this->flashMessages['save']);
		return back();
	}


	/*
	 * Редактирование отдельной записи
	 */
	function editOne(Request $request) {
		$this->authorize($this->abilities['edit']);

		$id = $request->id;

		return view($this->view['edit'], [
			'model' => $this->getQueryFromModel($id)->first()
		]);
	}


	/*
	 * Сохранение отдельной записи
	 */
	function saveOne(Request $request) {
		$this->authorize($this->abilities['edit']);
		$rule = isset($this->rules['names.*']) ? $this->rules['names.*'] . $request->id : '';

		$this->validate(
			$request,
			[$rule],
			$this->validateMessages);

		$this->getQueryFromModel($request->id)->update($request->except(['_method', '_token']));

		$message = isset($this->flashMessages['saveOne']) ? $this->flashMessages['saveOne'] : 'Изменения сохранениы';
		flash()->success($message);

		$goto = isset($this->route) ? redirect( route($this->route['after_save']) ) : back();
		return $goto;
	}


	/*
	 * Удаление отдельной записи
	 */
	function destroyOne(Request $request) {
		$this->authorize($this->abilities['edit']);
		
		$model = $this->model;
		
		$model::find($request->id)->delete();

		$message = isset($this->flashMessages['destroyOne']) ? $this->flashMessages['destroyOne'] : 'Изменения сохранениы';
		flash()->success($message);

		$goto = isset($this->route) ? redirect( route($this->route['after_destroy']) ) : back();
		return $goto;
	}


	/*
	 * Позиционирование
	 */
	public function positioning(Request $request) {
		$this->authorize($this->abilities['edit']);
		$this->setPositions($request, $this->model);
	}
}