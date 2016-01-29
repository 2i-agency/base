<?php

namespace Chunker\Base\Listeners;

use Carbon\Carbon;

class UserListener
{
	/*
	 * При авторизации пользователя
	 */
	public function onUserLogin($event)
	{
		// Добавление записи об авторизации
		$event
			->user
			->authorizations()
			->create(['is_failed' => $event->isFailed]);
	}


	/*
	 * При направлении запросу приложения от пользователя
	 */
	public function onUserAppRequest($event)
	{
		// Добавление данных в последнюю авторизацию, если таковая имеется
		$authorizations = $event
			->user
			->authorizations();

		if ($authorizations->count())
		{
			$authorization = $authorizations
				->latest('logged_in_at')
				->first();

			$authorization->last_request_at = Carbon::now();
			$authorization->save();
		}
	}


	/*
	 * Регистрация слушателей
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