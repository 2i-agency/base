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
		$this->authorize($this->ability_view);

		$model = $this->model;

		return view($this->view, [
			'directory' => $model::defaultOrder()->get()
		]);
	}


	/*
	 * Добавление
	 */
	function store(Request $request) {
		$this->authorize($this->ability_edit);
		$this->validate($request, $this->rules, $this->messages);

		$model = $this->model;
		$model::create($request->all());

		flash()->success($this->messages_flash['store']);
		return back();
	}


	/*
	 * Обновление списка
	 */
	function update(Request $request) {
		$this->authorize($this->ability_edit);
		$this->validate($request, ['names.*' => 'required'], $this->messages);

		$key_delete = isset($request->delete) ? array_keys($request->delete) : [];
		$model = $this->model;
		$new_names = $request->names;
		$old_names = $model::pluck('name', 'id')->toArray();
		$errors_renames = false;

		foreach ($key_delete as $id) {
			$model::find($id)->delete();
		}

		foreach ($new_names as $id => $name) {
			$old_id = array_search($name, $old_names);
			$is_delete = array_search($id, $key_delete);

			if (is_bool($is_delete)) {
				if (is_bool($old_id)) {
					$model::find($id)->update(['name' => $name]);
					$old_names[$id] = $name;
				} elseif ($old_id != $id) {
					$errors_renames = true;
				}
			}
		}

		if ($errors_renames) {
			flash()->error($this->messages_flash['update_error']);
		} else {
			flash()->success($this->messages_flash['update_success']);
		}

		return back();
	}


	/*
	 * Позиционирование
	 */
	public function positioning(Request $request) {
		$this->authorize($this->ability_edit);
		$this->setPositions($request, $this->model);
	}
}