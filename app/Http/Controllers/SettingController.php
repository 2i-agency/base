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
			$settings = [];

			foreach (config('chunker.admin.settings')[$section]['options'] as $id) {
				$settings[$id] = Setting
					::where('id', $id)
					->first([
						'title',
						'value',
						'control_type',
						'hint',
						'updater_id',
						'created_at',
						'updated_at'])
					->toArray();
			}

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

		return back();
	}
}