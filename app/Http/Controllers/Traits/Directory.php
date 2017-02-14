<?php

namespace Chunker\Base\Http\Controllers\Traits;

use Illuminate\Http\Request;

/**
 * Содержит в себе методы необходимые для организации каталогов
 *
 * @package Chunker\Base\Http\Controllers\Traits
 */
trait Directory
{
	use Positioning;

	/**
	 * @var array массив правил для валидации входных данных.
	 *
	 * Необходимо объявить в классе, к которому подключён трейт
	 */
//	protected $rules;

	/**
	 * @var array массив сообщений о провале валидации.
	 *
	 * Необходимо объявить в классе, к которому подключён трейт
	 */
//	protected $validateMessages;

	/**
	 * @var array массив сообщений для хелпера flash.
	 *
	 * Необходимо объявить в классе, к которому подключён трейт
	 */
//	protected $flashMessages = [
//		'store'      => '',
//		'save'       => '',
//		'saveOne'    => '',
//		'destroyOne' => '',
//	];

	/**
	 * @var mixed параметр, хранящий в себе класс модели.
	 *
	 * Необходимо объявить в классе, к которому подключён трейт
	 */
//	protected $model;

	/**
	 * @var array массив возможностей для каталога.
	 *
	 * Необходимо объявить в классе, к которому подключён трейт
	 */
//	protected $abilities = [
//		'view' => '',
//		'edit' => ''
//	];

	/**
	 * @var array массив роутов для редиректов.
	 */
//	protected $route = [
//		'after_save'    => '',
//		'after_destroy' => ''
//	];

	/**
	 * @var array массив представлений.
	 *
	 * Необходимо объявить в классе, к которому подключён трейт
	 */
//	protected $view = [
//		'index' => '',
//		'edit'  => ''
//	];


	/**
	 * Возвращает модель по ключу.
	 *
	 * @param string|int $id
	 *
	 * @return mixed
	 */
	protected function getModelById($id) {
		$model = new $this->model;
		$route_key_name = $model->getRouteKeyName();

		return $model->where($route_key_name, $id)->first();
	}


	/**
	 * Показывает список всех элементов каталога
	 */
	function index() {
		$this->authorize($this->abilities[ 'view' ]);

		$model = $this->model;
		$view = is_string($this->view) ? $this->view : $this->view[ 'index' ];

		return view($view, [
			'directory' => $model::withDelete()->defaultOrder()->get()
		]);
	}


	/**
	 * Сохранение нового элемента каталога
	 */
	function store(Request $request) {
		$this->authorize($this->abilities[ 'edit' ]);
		$this->validate($request, $this->rules, $this->validateMessages);

		$model = $this->model;
		$model::create($request->all());

		flash()->success($this->flashMessages[ 'store' ]);

		return back();
	}


	/**
	 * Обновление существующих элементов каталога
	 */
	function save(Request $request) {
		$this->authorize($this->abilities[ 'edit' ]);

		$model = $this->model;
		$names = $request->names;

		/** Удаление элементов, которые отметили */
		$keys_delete = isset($request->delete) ? array_keys($request->delete) : [];
		$model::destroy($keys_delete);

		foreach ($names as $id => $name) {
			$is_delete = in_array($id, $keys_delete);
			$rule = isset($this->rules[ 'names.*' ]) ? $this->rules[ 'names.*' ] . $id : '';

			if (!$is_delete) {
				$this->validate(
					$request,
					[ 'names.*' => $rule ],
					$this->validateMessages);
				$model::find($id)->update([ 'name' => $name ]);
			}

		}

		flash()->success($this->flashMessages[ 'save' ]);

		return back();
	}


	/**
	 * Редактирование отдельного элемента каталога
	 */
	function editOne(Request $request) {
		$this->authorize($this->abilities[ 'view' ]);

		$id = $request->id;

		return view($this->view[ 'edit' ], [
			'model' => $this->getModelById($id)
		]);
	}


	/**
	 * Обновление отдельного элемента каталога
	 */
	function saveOne(Request $request) {
		$this->authorize($this->abilities[ 'edit' ]);

		$this->validate(
			$request,
			[
				"name" => isset($this->rules[ 'name' ]) ? $this->rules[ 'name' ] . $request->slug : '',
				"slug" => isset($this->rules[ 'slug' ]) ? $this->rules[ 'slug' ] . $request->slug : ''
			],
			$this->validateMessages);

		$this->getModelById($request->id)->update($request->except([ '_method', '_token' ]));

		$message = isset($this->flashMessages[ 'saveOne' ]) ? $this->flashMessages[ 'saveOne' ] : 'Изменения сохранениы';
		flash()->success($message);

		return isset($this->route) ? redirect(route($this->route[ 'after_save' ])) : back();
	}


	/**
	 * Удаление отдельного элемента каталога
	 *
	 * @param Request $request
	 */
	function destroyOne(Request $request) {
		$this->authorize($this->abilities[ 'admin' ]);

		$this->getModelById($request->id)->delete();

		$message = isset($this->flashMessages[ 'destroyOne' ]) ? $this->flashMessages[ 'destroyOne' ] : 'Изменения сохранениы';
		flash()->success($message);

		return isset($this->route) ? redirect(route($this->route[ 'after_destroy' ])) : back();
	}


	/**
	 * Обновление информаии о позиционировании элементов каталога
	 *
	 * @param Request $request
	 */
	public function positioning(Request $request) {
		$this->authorize($this->abilities[ 'edit' ]);
		$this->setPositions($request, $this->model);
	}


	/**
	 * Удаление элемента каталога
	 *
	 * @param Request $request
	 */
	public function restore(Request $request) {

		$model = new $this->model;

		$model = $model
			->withDelete()
			->where($model->getRouteKeyName(), $request->id)
			->first();

		$this->authorize($this->abilities[ 'admin' ], $model);

		$model->restore();

		$message = isset($this->flashMessages[ 'restore' ]) ? $this->flashMessages[ 'restore' ] : 'Объект восстановлен';
		flash()->success($message);

		return back();
	}
}