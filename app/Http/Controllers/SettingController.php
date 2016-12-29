<?php

namespace Chunker\Base\Http\Controllers;

use App\Http\Controllers\Controller;
use Chunker\Base\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
	/**
	 * Раздел настроек
	 *
	 * @param null $section
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function section($section = NULL){
		$this->authorize('settings.view');

		/** Переадресация в первый раздел */
		if (is_null($section)) {
			$section = key(config('chunker.admin.settings'));

			return redirect()->route('admin.settings', $section);
		} /** Содержимое раздела */
		else {
			$settings = Setting
				::whereIn('id', config('chunker.admin.settings')[ $section ][ 'options' ])
				->get();

			return view(
				'base::settings.section',
				compact('section', 'settings')
			);
		}
	}


	/**
	 * Сохранение
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function save(Request $request){
		$this->authorize('settings.edit');

		foreach ($request->get('settings') as $id => $value) {
			Setting::find($id)->update([ 'value' => $value ]);
		}

		flash()->success('Настройки сохранены');

		return back();
	}
}