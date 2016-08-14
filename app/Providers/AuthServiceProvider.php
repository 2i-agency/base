<?php

namespace Chunker\Base\Providers;

use Chunker\Base\Models\Ability;
use Chunker\Base\Models\User;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
	/*
	 * Карта политик приложения
	 */
	protected $policies = [];


	/*
	 * Регистрация сервисов аутентификации и авторизации приложения
	 */
	public function boot(GateContract $gate) {
		$this->registerPolicies($gate);

		// Регистрация правил в соответствии с таблицей в базе
		foreach (Ability::pluck('id') as $ability) {
			$gate->define($ability, function(User $user) use ($ability) {
				if (explode('.', $ability)[1] == 'view') {
					return $user->hasAccess($ability);
				} else {
					return $user->hasAbility($ability);
				}
			});
		}
	}
}
