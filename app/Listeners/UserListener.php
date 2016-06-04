<?php

namespace Chunker\Base\Listeners;

use Carbon\Carbon;

class UserListener
{
	/*
	 * При аутентификации пользователя
	 */
	public function onUserLogin($event) {
		// Добавление записи об аутентификации
		$event
			->user
			->authentications()
			->create(['is_failed' => $event->isFailed]);
	}


	/*
	 * При направлении запроса приложению от пользователя
	 */
	public function onUserAppRequest($event) {
		// Добавление данных в последнюю авторизацию, если таковая имеется
		$authentications = $event
			->user
			->authentications();

		if ($authentications->count()) {
			$authentications
				->latest('logged_in_at')
				->first()
				->update(['last_request_at' => Carbon::now()]);
		}
	}


	/*
	 * Регистрация слушателей
	 */
	public function subscribe($events) {
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