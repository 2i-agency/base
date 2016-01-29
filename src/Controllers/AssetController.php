<?php

namespace Chunker\Base\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AssetController extends Controller
{
	/*
	 * Скачивание ассета админцентра
	 */
	protected function download($filename, $headers = [])
	{
		if (file_exists($filename))
		{
			return response()->download($filename, NULL, $headers);
		}
		else
		{
			abort(404);
		}
	}


	/*
	 * Скачивание CSS-ассета
	 */
	public function css($filename)
	{
		$filename = storage_path('app/admin/css/' . $filename);
		return $this->download($filename, ['Content-type' => 'text/css']);
	}


	/*
	 * Скачивание JS-ассета
	 */
	public function js($directory, $filename)
	{
		$filename = storage_path('app/admin/js/' . $directory . '/' . $filename);
		return $this->download($filename, ['Content-type' => 'text/javascript']);
	}
}