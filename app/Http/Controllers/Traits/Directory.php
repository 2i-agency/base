<?php

namespace Chunker\Base\Http\Controllers\Traits;

use Illuminate\Http\Request;
use App\Http\Requests;

trait Directory
{
	use Positioning;

	/*
	 * Отображение
	 */
	function index() {
		$this->authorize($this->abilities['view']);

		$model = $this->model;

		return view($this->view, [
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
			
			if (is_bool($is_delete)) {
				$this->validate(
					$request,
					['names.*' => 'required|unique:houses_projects_categories,name,' . $id],
					$this->validateMessages);
				$model::find($id)->update(['name' => $name]);
			}

		}

		flash()->success($this->flashMessages['save']);
		return back();
	}


	/*
	 * Позиционирование
	 */
	public function positioning(Request $request) {
		$this->authorize($this->abilities['edit']);
		$this->setPositions($request, $this->model);
	}
}