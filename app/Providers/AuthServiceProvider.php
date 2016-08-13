<?php

namespace Chunker\Base\Providers;

use Chunker\Base\Models\Notice;
use Chunker\Base\Policies\NoticePolicy;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
	/*
	 * Карта политик приложения
	 */
	protected $policies = [
		Notice::class => NoticePolicy::class
	];


	/*
	 * Регистрация сервисов аутентификации и авторизации приложения
	 */
	public function boot(GateContract $gate) {
		$this->registerPolicies($gate);
	}
}
