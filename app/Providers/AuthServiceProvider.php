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


	public function boot(GateContract $gate){
		$this->registerPolicies($gate);

		/** Регистрация правил в соответствии с таблицей в базе */
		if (Schema::hasTable(with(new Ability)->getTable())) {
			foreach (Ability::pluck('id') as $ability) {
				$gate->define($ability, function(User $user) use ($ability){
					if (explode('.', $ability)[ 1 ] == 'view') {
						return $user->hasAccess($ability);
					} else {
						return $user->hasAbility($ability);
					}
				});
			}
		}

		/** Возможность просмотра пользователя */
		$gate->define('users.view', function(User $user, User $editableUser = NULL){
			if (is_null($editableUser)) {
				return $user->hasAccess('users.view');
			} else {
				return $user->hasAccess('users.view') || $user->id == $editableUser->id;
			}
		});

		/** Возможность редактирования пользователя */
		$gate->define('users.edit', function(User $user, User $editableUser = NULL){
			if (is_null($editableUser)) {
				return $user->hasAbility('users.edit');
			} else {
				return $user->hasAbility('users.edit') || $user->id == $editableUser->id;
			}
		});
	}
}
