<?php

namespace Chunker\Base\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Storage;
use App;

class TranslationController extends Controller
{
	/**
	 * Список разделов интерфейса
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(){
		$this->authorize('translation.view');

		return view('base::translation.sections');
	}


	/**
	 * Список элементов раздела
	 *
	 * @param $section
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function section($section){
		$this->authorize('translation.view');

		$data = config('chunker.localization.interface')[ $section ];
		$title = $data[ 0 ];
		$fields = [];

		/** Буферизация текущей локали для корректной работы функции 'trans' */
		$current_locale = App::getLocale();
		App::setLocale(Session::get('admin.locale'));

		/** Подготовка полей */
		foreach ($data[ 1 ] as $elem_name => $elem_data) {
			/** Если поле описано полностью */
			if (is_array($elem_data)) {
				$field = [
					'name'  => $elem_name,
					'title' => $elem_data[ 0 ],
					'type'  => $elem_data[ 1 ]
				];
			} /** Если описано в компактной форме */
			else {
				$field = [
					'name'  => $elem_name,
					'title' => $elem_data,
					'type'  => 'text'
				];
			}

			/** Значение поля */
			$trans_id = 'chunker::' . $section . '.' . $elem_name;
			$field[ 'value' ] = ( trans($trans_id) == $trans_id ) ? NULL : trans($trans_id);

			$fields[] = $field;
		}

		/** Установка текущей локали */
		App::setLocale($current_locale);

		return view('base::translation.section', compact('section', 'title', 'fields'));
	}


	/**
	 * Сохранение перевода
	 *
	 * @param Request $request
	 * @param         $section
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function save(Request $request, $section){
		$this->authorize('translation.edit');

		/** Перевод элементов */
		$elements = $request->get('elements');

		/** Диск для сохранения файла с локализацией */
		$directory = base_path('resources/lang/vendor/chunker/' . Session::get('admin.locale'));
		$disk = Storage::createLocalDriver([ 'root' => $directory ]);
		$filename = $section . '.php';

		/** Запись контента в файл */
		$content = '<?php return ' . var_export($elements, true) . ';';
		$disk->put($filename, $content);

		flash()->success('Перевод элементов сохранён');

		return back();
	}
}