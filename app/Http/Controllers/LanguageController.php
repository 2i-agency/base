<?php

namespace Chunker\Base\Http\Controllers;

use Chunker\Base\Models\Language;
use Chunker\Base\Http\Controllers\Traits\Positioning;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
	use Positioning;

	protected $rules = [
		'name' => 'required',
		'locale' => 'sometimes|min:2|alpha_dash|unique:languages,locale'
	];

	protected $messages = [
		'name.require' => 'Необходимо указать название языка',
		'locale.min' => 'Псевдоним должен содержать не менее :min символов',
		'locale.alpha_dash' => 'Псевдоним может содержать только буквы, цифры, дефис и нижнее подчёркивание',
		'locale.unique' => 'Язык с таким псевдонимом уже существует'
	];


	public function __construct(Request $request) {
		// Приведение ключа маршрута в требуемый вид
		$data = $request->all();

		if (isset($data['locale']) || isset($data['name']))
		{
			$data['locale'] = str_slug(mb_strlen(trim($data['locale']))
				? $data['locale']
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
		$language = Language::create($request->only(['name', 'locale']));
		flash()->success('Язык <b>' . e($language->name) . '</b> добавлен');

		return back();
	}


	/*
	 * Обновление языка
	 */
	public function update(Request $request, Language $language) {
		// Валидация
		$this->rules['locale'] .= ',' . $language->id;
		$this->validate($request, $this->rules, $this->messages);

		// Обновление
		$language->update($request->only(['name', 'locale', 'is_published']));

		// Уведомление
		flash()->success('Данные языка <b>' . e($language->name) . '</b> сохранены');


		return back();
	}


	/*
	 * Позиционирование языков
	 */
	public function positioning(Request $request) {
		$this->setPositions($request, Language::class);
	}
}