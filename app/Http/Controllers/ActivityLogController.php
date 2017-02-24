<?php

namespace Chunker\Base\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Chunker\Base\Http\Controllers\Traits\Pagination;
use Chunker\Base\Models\Role;
use Chunker\Base\Models\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
	use Pagination;


	public function index(Request $request) {
		$this->authorize('activity-log.view');

		$activity_user = Activity::pluck('causer_id')->toArray();

		$users = User::isRootAdmin()->whereIn('id', $activity_user)->get();

		$roles = Role::get();

		$activities = Activity::orderBy('id', 'desc');

		if (isset($request->published_since) && $request->published_since != '') {
			$activities = $activities->where('created_at', '>=', Carbon::parse($request->published_since));
		}

		if (isset($request->published_until) && $request->published_until != '') {
			$activities = $activities->where('created_at', '<=', Carbon::parse($request->published_until));
		}

		if (isset($request->log_name) && $request->log_name != '') {
			$activities = $activities->where('log_name', $request->log_name);
		}

		if (isset($request->causes) && $request->causes != '') {
			$causes = explode(':', $request->causes);

			if (array_first($causes) == 'user') {
				$activities = $activities->where('causer_id', array_last($causes));
			} else {
				$users_role = Role::find(array_last($causes))->users()->pluck('id')->toArray();
				$activities = $activities->whereIn('causer_id', $users_role);
			}
		}

		if (isset($request->element) && $request->element != '') {
			if ($request->element == 'localization') {
				$activities = $activities->where('properties', 'like', '%localization%');
			} else {
				$activities = $activities->where('subject_type', $request->element);
			}
		}

		$activities = $activities->paginate(30);

		return view('base::activity-log.list', compact('activities', 'users', 'roles'));
	}
}