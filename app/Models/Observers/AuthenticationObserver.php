<?php

namespace Chunker\Base\Models\Observers;

use Carbon\Carbon;
use Chunker\Base\Models\Authentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AuthenticationObserver
{
	public function creating(Authentication $authentication) {
		$request = Request::capture();

		$authentication->fill([
			'logged_in_at' => Carbon::now(),
			'ip_address' => $request->ip(),
			'user_agent' => $request->server('HTTP_USER_AGENT')
		]);
	}
}