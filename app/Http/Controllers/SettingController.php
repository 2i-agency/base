<?php

namespace Chunker\Base\Http\Controllers;

use App\Http\Controllers\Controller;
use Chunker\Base\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
	/*
	 * Раздел настроек
	 */
	public function section($section = NULl) {
		// Переадресация в первый раздел
		if (is_null($section))
		{
			$section = key(config('chunker.admin.settings'));
			return redirect()->route('admin.settings', $section);
		}
		// Содержимое раздела
		else
		{
			$settings = Setting
				::whereIn('id', config('chunker.admin.settings')[$section]['options'])
				->get();

			return view('chunker.base::admin.settings.section', compact('section', 'settings'));
		}
	}


	/*
	 * Сохранение
	 */
	public function save(Request $request) {
		foreach ($request->get('settings') as $id => $value)
		{
			Setting::find($id)->update(['value' => $value]);
		}

		flash()->success('Настройки сохранены');


		return back();
	}
}