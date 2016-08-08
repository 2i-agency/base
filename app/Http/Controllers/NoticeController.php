<?php

namespace Chunker\Base\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Chunker\Base\Http\Controllers\Traits\Pagination;
use Illuminate\Http\Request;
use Chunker\Base\Models\Notice;
use Chunker\Base\Models\NoticesType;

class NoticeController extends Controller
{
	use Pagination;


	/*
	 * Список уведомлений
	 */
	public function index(Request $request) {
		$notices = Notice
			::orderBy('is_read')
			->latest();

		// Фильтрация
		if ($request->has('type')) {
			// Тип
			if ($request->get('type') == 'none') {
				$notices->whereNull('type_id');
			} elseif ((int)$request->get('type')) {
				$notices->where('type_id', $request->get('type'));
			}

			// Статус
			if ($request->get('is_read') == 'read') {
				$notices->where('is_read', true);
			} else if ($request->get('is_read') == 'not_read') {
				$notices->where('is_read', false);
			}

			// С
			if ($request->has('since')) {
				$notices->where('created_at', '>=', Carbon::parse($request->get('since')));
			}

			// По
			if ($request->has('until')) {
				$notices->where('created_at', '<=', Carbon::parse($request->get('until')));
			}
		}

		$notices = $notices
			->paginate(10)
			->appends($request->only(['type', 'is_read', 'since', 'until']));


		// Результат
		if ($this->isNeedRedirectByPaginator($notices)) {
			return $this->redirectByPaginator($notices);
		} else {
			// Типы уведомлений
			$notices_types = NoticesType
				::orderBy('name')
				->get(['id', 'name']);

			return view('chunker.base::admin.notices.list', compact('notices', 'notices_types'));
		}
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