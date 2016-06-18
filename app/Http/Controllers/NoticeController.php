<?php

namespace Chunker\Base\Http\Controllers;

use App\Http\Controllers\Controller;
use Chunker\Base\Models\Notice;

class NoticeController extends Controller
{
	/*
	 * Список уведомлений
	 */
	public function getIndex() {
		$notices = Notice
			::orderBy('is_read')
			->latest()
			->paginate(10);

		return view('chunker.base::admin.notices.list', compact('notices'));
	}


	/*
	 * Отметка прочтения уведомления
	 */
	public function putReadNotice($noticeId) {
		Notice
			::findOrFail($noticeId)
			->update(['is_read' => true]);

		flash()->success('Уведомление <b>№' . $noticeId . '</b> отмечено, как прочитанное');

		return back();
	}


	/*
	 * Удаление уведомления
	 */
	public function deleteDestroyNotice($noticeId) {
		Notice::destroy($noticeId);
		flash()->warning('Уведомление <b>№' . $noticeId . '</b> удалено');

		return back();
	}
}