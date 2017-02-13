<?php

namespace Chunker\Base\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Chunker\Base\Http\Controllers\Traits\Pagination;
use Chunker\Base\Models\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
	use Pagination;


	public function index(Request $request) {
		$this->authorize('activity-log.view');

		$users = User::isRootAdmin()->get();

		$activities = Activity::orderBy('id', 'desc');

		if (isset($request->published_since) && $request->published_since != '') {
			$activities = $activities->where('created_at', '>=', Carbon::parse($request->published_since));
		}

		if (isset($request->published_until) && $request->published_until != '') {
			$activities = $activities->where('created_at', '<=', Carbon::parse($request->published_until));
		}

		if (isset($request->user) && $request->user != '') {
			$activities = $activities->where('causer_id', $request->user);
		}

		if (isset($request->element) && $request->element != '') {
			$activities = $activities->where('subject_type', $request->element);
		}

		$activities = $activities->paginate(30);

		return view('base::activity-log.list', compact('activities', 'users'));
	}
}