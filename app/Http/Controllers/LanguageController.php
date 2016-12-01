<?php

namespace Chunker\Base\Http\Controllers;

use Chunker\Base\Models\Language;
use Chunker\Base\Http\Controllers\Traits\Positioning;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;

class LanguageController extends Controller
{
	use Positioning;

	protected $rules = [
		'name' => 'required',
		'locale' => 'sometimes|min:2|alpha_dash|unique:base_languages,locale'
	];

	protected $messages = [
		'name.require' => 'Необходимо указать название языка',
		'locale.min' => 'Локаль должна содержать не менее :min символов',
		'locale.alpha_dash' => 'Локаль может содержать только буквы, цифры, дефис и нижнее подчёркивание',
		'locale.unique' => 'Язык с такой локалью уже существует'
	];


	/*
	 * Сохранение иконки для языка
	 */
	protected function saveIcon(Language $model) {
		$request = request();
		$file = isset($request->allFiles()['icon']) ? $request->allFiles()['icon'] : null;
		$delete_icon = isset($request->delete_icon) ? $request->delete_icon : false;

		// Разрешено ли использовать иконку
		if (config('chunker.localization.icon.using')) {

			$model_icons = $model->getMedia();

			if (!is_null($file) && $file->isValid()) {

				// Если в базе уже есть флаг, то удалить его
				if ($model->hasMedia()) {
					foreach ($model_icons as $model_icon) {
						$model_icon->delete();
					}
				}

				$extension = $file->clientExtension() != 'bin' ? $file->clientExtension() : $file->extension();

				// Добавить новый флаг
				$model->copyMedia($file)
					->setFileName('original.' . $extension)
					->toCollection('language.icon');
			}
			elseif ($delete_icon) {
				// Если в базе уже есть флаг, то удалить его
				if ($model->hasMedia()) {
					foreach ($model_icons as $model_icon) {
						$model_icon->delete();
					}
				}
			}

		}

	}


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
		$this->authorize('languages.view');

		return view('chunker.base::admin.languages.list', [
			'languages' => Language::defaultOrder()->get()
		]);
	}


	/*
	 * Добавление языка
	 */
	public function store(Request $request) {
		$this->authorize('languages.edit');

		$this->validate($request, $this->rules, $this->messages);
		$language = Language::create($request->only(['name', 'locale']));

		// Сохраняем иконку языка
		$this->saveIcon($language);

		flash()->success('Язык <b>' . e($language->name) . '</b> добавлен');

		return back();
	}


	/*
	 * Обновление языка
	 */
	public function update(Request $request, Language $language) {
		$this->authorize('languages.edit');

		// Валидация
		$this->rules['locale'] .= ',' . $language->id;
		$this->validate($request, $this->rules, $this->messages);

		// Обновление
		$language->update($request->only(['name', 'locale', 'is_published']));

		// Сохраняем иконку языка
		$this->saveIcon($language);

		// Уведомление
		flash()->success('Данные языка <b>' . e($language->name) . '</b> сохранены');


		return back();
	}


	/*
	 * Позиционирование языков
	 */
	public function positioning(Request $request) {
		$this->authorize('languages.edit');
		$this->setPositions($request, Language::class);
	}
}