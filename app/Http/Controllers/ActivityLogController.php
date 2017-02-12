<?php

namespace Chunker\Base\Http\Controllers;

use App\Http\Controllers\Controller;
use Chunker\Base\Http\Controllers\Traits\Pagination;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
	use Pagination;


	public function index(Request $request) {
		$this->authorize('activity-log.view');
		$activities = Activity::orderBy('id', 'desc')->paginate(30);

		return view('base::activity-log.list', compact('activities'));
	}
}