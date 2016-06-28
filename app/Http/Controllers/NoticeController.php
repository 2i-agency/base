<?php

namespace Chunker\Base\Http\Controllers;

use App\Http\Controllers\Controller;
use Chunker\Base\Models\Notice;

class NoticeController extends Controller
{
	/*
	 * Список уведомлений
	 */
	public function index() {
		$notices = Notice
			::orderBy('is_read')
			->latest()
			->paginate(10);

		return view('chunker.base::admin.notices.list', compact('notices'));
	}


	/*
	 * Отметка прочтения уведомления
	 */
	public function read(Notice $notice) {
		$notice->update(['is_read' => true]);
		flash()->success('Уведомление <b>№' . $notice->id . '</b> отмечено, как прочитанное');

		return back();
	}


	/*
	 * Удаление уведомления
	 */
	public function destroy(Notice $notice) {
		$notice->delete();
		flash()->warning('Уведомление <b>№' . $notice->id . '</b> удалено');

		return back();
	}
}