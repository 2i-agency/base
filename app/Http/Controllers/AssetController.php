<?php

namespace Chunker\Base\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AssetController extends Controller
{
	/*
	 * Скачивание ассета админцентра
	 */
	protected function download($filename, $headers = []) {
		if (file_exists($filename)) {
			return response()->download($filename, NULL, $headers);
		} else {
			abort(404);
		}
	}


	/*
	 * Скачивание CSS-ассета
	 */
	public function css($filename) {
		$filename = storage_path('app/admin/css/' . $filename);
		return $this->download($filename, ['Content-type' => 'text/css']);
	}


	/*
	 * Скачивание JS-ассета
	 */
	public function js($directory, $filename) {
		$filename = storage_path('app/admin/js/' . $directory . '/' . $filename);
		return $this->download($filename, ['Content-type' => 'text/javascript']);
	}


	/*
	 * Скачивание изображения
	 */
	public function img($filename) {
		$filename = storage_path('app/admin/img/' . $filename);
		$image_info = getimagesize($filename);
		$mime_type = image_type_to_mime_type($image_info[2]);

		return $this->download($filename, ['Content-type' => $mime_type]);
	}
}