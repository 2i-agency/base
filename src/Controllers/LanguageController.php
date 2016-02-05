<?php

namespace Chunker\Base\Controllers;

use Chunker\Base\Models\Language;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
	/*
	 * Список языков
	 */
	public function index()
	{
		return view('Base::languages.index', [
			'languages' => Language::positioned()->get()
		]);
	}


	/*
	 * Добавление языка
	 */
	public function store(Request $request)
	{
		Language::create($request->only(['name', 'alias']));
		return redirect()->back();
	}


	/*
	 * Обновление языка
	 */
	public function update(Request $request, Language $language)
	{
		$language->update($request->only(['name', 'alias', 'is_published']));
		return redirect()->back();
	}


	/*
	 * Позиционирование языков
	 */
	public function positioning(Request $request)
	{
		Language::find($request->get('id'))
			->placeTo($request->get('position'));
	}
}