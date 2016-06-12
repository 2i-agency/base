<?php

namespace Chunker\Base\Http\Controllers;

use Chunker\Base\Models\Language;
use Chunker\Base\Http\Controllers\Traits\Positioning;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
	use Positioning;

	protected $rules = [
		'name' => 'required',
		'route_key' => 'sometimes|min:2|alpha_dash|unique:languages,route_key'
	];

	protected $messages = [
		'name.require' => 'Необходимо указать название языка',
		'route_key.min' => 'Псевдоним должен содержать не менее :min символов',
		'route_key.alpha_dash' => 'Псевдоним может содержать только буквы, цифры, дефис и нижнее подчёркивание',
		'route_key.unique' => 'Язык с таким псевдонимом уже существует'
	];


	public function __construct(Request $request) {
		// Приведение ключа маршрута в требуемый вид
		$data = $request->all();

		if (isset($data['route_key']) || isset($data['name']))
		{
			$data['route_key'] = str_slug(mb_strlen(trim($data['route_key']))
				? $data['route_key']
				: $data['name']);

			$request->replace($data);
		}
	}


	/*
	 * Список языков
	 */
	public function index() {
		return view('chunker.base::admin.languages.list', [
			'languages' => Language::defaultOrder()->get()
		]);
	}


	/*
	 * Добавление языка
	 */
	public function store(Request $request) {
		$this->validate($request, $this->rules, $this->messages);
		$language = Language::create($request->only(['name', 'route_key']));
		flash()->success('Язык <b>' . e($language->name) . '</b> добавлен');

		return redirect()->back();
	}


	/*
	 * Обновление языка
	 */
	public function update(Request $request, Language $language) {
		// Валидация
		$this->rules['route_key'] .= ',' . $language->id;
		$this->validate($request, $this->rules, $this->messages);

		// Обновление
		$language->update($request->only(['name', 'route_key', 'is_published']));

		// Уведомление
		flash()->success('Данные языка <b>' . e($language->name) . '</b> сохранены');


		return redirect()->back();
	}


	/*
	 * Позиционирование языков
	 */
	public function positioning(Request $request) {
		$this->setPositions($request, Language::class);
	}
}