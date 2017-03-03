<?php

namespace Chunker\Base\Providers;

use Chunker\Base\Models\Ability;
use Chunker\Base\Models\User;
use Schema;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
	/** @var array Карта политик приложения */
	protected $policies = [];


	public function boot(GateContract $gate) {
		$this->registerPolicies($gate);

		/** Регистрация правил в соответствии с таблицей в базе */
		if (Schema::hasTable(with(new Ability)->getTable())) {
			foreach (Ability::pluck('id') as $ability) {
				$gate->define($ability, function(User $user, $model) use ($ability) {
					if (explode('.', $ability)[ 1 ] == 'view') {
						return $user->hasAccess($ability, $model);
					} else {
						return $user->hasAbility($ability, $model);
					}
				});
			}
		}
	}
}
