<?php

namespace Chunker\Base\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Storage;

class TranslationController extends Controller
{
	/*
	 * Список разделов интерфейса
	 */
	public function index() {
		return view('chunker.base::translation.index');
	}


	/*
	 * Список элементов раздела
	 */
	public function section($section) {
		$data = config('chunker.localization.interface')[$section];
		$title = $data[0];
		$fields = [];

		// Подготовка полей
		foreach ($data[1] as $elem_name => $elem_data) {
			// Если поле описано полностью
			if (is_array($elem_data)) {
				$field = [
					'name' => $elem_name,
					'title' => $elem_data[0],
					'type' => $elem_data[1]
				];
			} // Если описано в компактной форме
			else {
				$field = [
					'name' => $elem_name,
					'title' => $elem_data,
					'type' => 'text'
				];
			}

			// Значение поля
			$trans_id = 'chunker::' . $section . '.' . $elem_name;
			$field['value'] = (trans($trans_id) == $trans_id) ? NULL : trans($trans_id);

			$fields[] = $field;
		}


		return view('chunker.base::translation.section', compact('section', 'title', 'fields'));
	}


	/*
	 * Сохранение перевода
	 */
	public function save(Request $request, $section) {
		// Перевод элементов
		$elements = $request->get('elements');

		// Диск для сохранения файла с локализацией
		$directory = base_path('resources/lang/vendor/chunker/' . Session::get('admin.locale'));
		$disk = Storage::createLocalDriver(['root' => $directory]);
		$filename = $section . '.php';

		// Формирование контента файла
		$content = NULL;
		$pairs = [];

		foreach ($elements as $name => $value) {
			$pairs[] = '"' . $name . '" => "' . e($value) . '"';
		}

		$content = '<?php return [' . implode(',', $pairs) . '];';

		// Запись файла
		$disk->put($filename, $content);


		return redirect()->back();
	}
}