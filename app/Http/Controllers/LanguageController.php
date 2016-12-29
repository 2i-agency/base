<?php

namespace Chunker\Base\Http\Controllers;

use Chunker\Base\Models\Language;
use Chunker\Base\Http\Controllers\Traits\Positioning;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
	use Positioning;

	/** @var array массив с правилами для валидации */
	protected $rules = [
		'name'   => 'required',
		'locale' => 'sometimes|min:2|alpha_dash|unique:base_languages,locale'
	];

	/** @var array массив сообщений для валидации */
	protected $messages = [
		'name.require'      => 'Необходимо указать название языка',
		'locale.min'        => 'Локаль должна содержать не менее :min символов',
		'locale.alpha_dash' => 'Локаль может содержать только буквы, цифры, дефис и нижнее подчёркивание',
		'locale.unique'     => 'Язык с такой локалью уже существует'
	];


	/**
	 * Удаление иконок
	 *
	 * @param Language $language
	 */
	protected function deleteIcons(Language $language){
		if ($language->hasMedia()) {
			$language_icons = $language->getMedia();

			foreach ($language_icons as $model_icon) {
				$model_icon->delete();
			}
		}
	}


	/**
	 * Сохранение иконки для языка
	 *
	 * @param Language $language
	 */
	protected function saveIcon(Language $language){
		$request = request();
		$file = isset($request->allFiles()[ 'icon' ]) ? $request->allFiles()[ 'icon' ] : NULL;
		$delete_icon = isset($request->delete_icon) ? $request->delete_icon : false;

		/** Разрешено ли использовать иконку */
		if (config('chunker.localization.icon.using')) {

			if (!is_null($file) && $file->isValid()) {

				/** Если в базе уже есть иконка, то удалить её */
				$this->deleteIcons($language);

				/** @var string $extension расширение для файла иконки */
				$extension = $file->clientExtension() != 'bin' ? $file->clientExtension() : $file->extension();

				/** Добавить новую иконку */
				$language->copyMedia($file)
					->setFileName('original.' . $extension)
					->toCollection('language.icon');
			} elseif ($delete_icon) {
				/** Если в базе уже есть иконка, то удалить её */
				$this->deleteIcons($language);
			}

		}

	}


	public function __construct(Request $request){
		/** Приведение ключа маршрута в требуемый вид */
		$data = $request->all();

		if (isset($data[ 'locale' ]) || isset($data[ 'name' ])) {
			$data[ 'locale' ] = str_slug(mb_strlen(trim($data[ 'locale' ]))
				? $data[ 'locale' ]
				: $data[ 'name' ]);

			$request->replace($data);
		}
	}


	/**
	 * Список языков
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(){
		$this->authorize('languages.view');

		return view('chunker.base::languages.list', [
			'languages' => Language::defaultOrder()->get()
		]);
	}


	/**
	 * Добавление языка
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(Request $request){
		$this->authorize('languages.edit');

		$this->validate($request, $this->rules, $this->messages);
		$language = Language::create($request->only([ 'name', 'locale' ]));

		/** Сохраняем иконку языка */
		$this->saveIcon($language);

		flash()->success('Язык <b>' . e($language->name) . '</b> добавлен');

		return back();
	}


	/**
	 * Обновление языка
	 *
	 * @param Request  $request
	 * @param Language $language
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(Request $request, Language $language){
		$this->authorize('languages.edit');

		/** Валидациявходных данных */
		$this->rules[ 'locale' ] .= ',' . $language->id;
		$this->validate($request, $this->rules, $this->messages);

		/** Обновление языка */
		$language->update($request->only([ 'name', 'locale', 'is_published' ]));

		/** Сохраняем иконку языка */
		$this->saveIcon($language);

		flash()->success('Данные языка <b>' . e($language->name) . '</b> сохранены');

		return back();
	}


	/**
	 * Позиционирование языков
	 *
	 * @param Request $request
	 */
	public function positioning(Request $request){
		$this->authorize('languages.edit');
		$this->setPositions($request, Language::class);
	}
}