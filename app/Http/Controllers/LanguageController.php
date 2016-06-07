<?php

namespace Chunker\Base\Http\Controllers;

use Chunker\Base\Models\Language;
use Chunker\Base\Http\Controllers\Traits\Positioning;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
	use Positioning;

	/*
	 * Список языков
	 */
	public function index() {
		return view('chunker.base::admin.languages.list', [
			'languages' => Language::defaultOrder()->get()
		]);
	}


	/*
	 * Добавление языка
	 */
	public function store(Request $request) {
		Language::create($request->only(['name', 'route_key']));
		return redirect()->back();
	}


	/*
	 * Обновление языка
	 */
	public function update(Request $request, Language $language) {
		$language->update($request->only(['name', 'route_key', 'is_published']));
		return redirect()->back();
	}


	/*
	 * Позиционирование языков
	 */
	public function positioning(Request $request) {
		$this->setPositions($request, Language::class);
	}
}