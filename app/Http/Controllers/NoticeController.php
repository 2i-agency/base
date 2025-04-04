<?php

namespace Chunker\Base\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Chunker\Base\Http\Controllers\Traits\Pagination;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Chunker\Base\Models\Notice;
use Chunker\Base\Models\NoticesType;

class NoticeController extends Controller
{
	use Pagination;


	/**
	 * Список уведомлений
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function index(Request $request){
		/** @var NoticesType $notices_types Типы уведомлений */
		$notices_types = NoticesType
			::orderBy('name')
			->whereHas('roles', function(Builder $query) use ($request){
				$query->whereIn('id', $request->user()->roles()->pluck('id'));
			})
			->orWhereHas('users', function(Builder $query) use ($request){
				$query->where('id', $request->user()->id);
			})
			->get([ 'id', 'name' ]);

		/** @var Notice $notices Уведомления */
		$notices = $request
			->user()
			->notices()
			->orderBy('is_read')
			->latest()
			->where(function(Builder $query) use ($notices_types){
				$query
					->whereIn('type_id', $notices_types->pluck('id'))
					->orWhereNull('type_id');
			});

		/** Фильтрация */
		if ($request->has('type')) {
			/** По типу */
			if ($request->get('type') == 'none') {
				$notices->whereNull('type_id');
			} elseif ((int)$request->get('type')) {
				$notices->where('type_id', $request->get('type'));
			}

			/** По статусу */
			if ($request->get('is_read') == 'read') {
				$notices->where('is_read', true);
			} else {
				if ($request->get('is_read') == 'not_read') {
					$notices->where('is_read', false);
				}
			}

			/** По временеи: с */
			if ($request->has('since')) {
				$notices->where('created_at', '>=', Carbon::parse($request->get('since')));
			}

			/** По времени: по  */
			if ($request->has('until')) {
				$notices->where('created_at', '<=', Carbon::parse($request->get('until')));
			}
		}

		$notices = $notices
			->paginate(10)
			->appends($request->only([ 'type', 'is_read', 'since', 'until' ]));

		/** Результат */
		if ($this->isNeedRedirectByPaginator($notices)) {
			return $this->redirectByPaginator($notices);
		} else {
			return view(
				'base::notices.list',
				compact('notices', 'notices_types')
			);
		}
	}


	/**
	 * Отметка прочтения уведомления
	 *
	 * @param Notice $notice
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function read(Notice $notice){
		$this->authorize('notices.edit');
		$notice->update([ 'is_read' => true ]);
		flash()->success('Уведомление <b>№' . $notice->id . '</b> отмечено, как прочитанное');

		return back();
	}


	/**
	 * Удаление уведомления
	 *
	 * @param Request $request
	 * @param Notice  $notice
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy(Request $request, Notice $notice){

		$notice->users()->detach($request->user()->id);
		if (!$notice->users()->count()) {
			$notice->delete();
		}

		flash()->warning('Уведомление <b>№' . $notice->id . '</b> удалено');

		return back();
	}
}