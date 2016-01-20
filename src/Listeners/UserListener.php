<?php

namespace Chunker\Base\Listeners;

use Carbon\Carbon;

class UserListener
{
	/*
	 * User logged in
	 */
	public function onUserLogin($event)
	{
		// Creating authorization
		$event
			->user
			->authorizations()
			->create(['failed' => $event->failed]);
	}


	/*
	 * User sent http request to app
	 */
	public function onUserAppRequest($event)
	{
		// Adding data to last authorization
		$authorization = $event
			->user
			->authorizations()
			->latest('logged_in_at')
			->first();

		$authorization->last_request_at = Carbon::now();
		$authorization->save();
	}


	/*
	 * Register the listeners
	 */
	public function subscribe($events)
	{
		$events->listen(
			'Chunker\Base\Events\UserLoggedIn',
			'Chunker\Base\Listeners\UserListener@onUserLogin'
		);

		$events->listen(
			'Chunker\Base\Events\UserRequestedApp',
			'Chunker\Base\Listeners\UserListener@onUserAppRequest'
		);
	}

}