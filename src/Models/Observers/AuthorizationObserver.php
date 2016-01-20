<?php

namespace Chunker\Admin\Models\Observers;

use Carbon\Carbon;
use Chunker\Admin\Models\Authorization;
use Illuminate\Support\Facades\Input;

class AuthorizationObserver
{
	public function creating(Authorization $authorization)
	{
		$authorization->fill([
			'logged_in_at' => Carbon::now(),
			'ip_address' => Input::server('REMOTE_ADDR'),
			'user_agent' => Input::server('HTTP_USER_AGENT')
		]);
	}
}