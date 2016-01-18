<?php

namespace Chunker\Admin\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AssetController extends Controller
{
	/*
	 * Getting admin's asset
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
	 * Getting admin's CSS file
	 */
	public function css($filename)
	{
		$filename = storage_path('app/admin/css/' . $filename);
		return $this->download($filename, ['Content-type' => 'text/css']);
	}


	/*
	 * Getting admin's JS file
	 */
	public function js($direcrory, $filename)
	{
		$filename = storage_path('app/admin/js/' . $direcrory . '/' . $filename);
		return $this->download($filename, ['Content-type' => 'text/javascript']);
	}
}