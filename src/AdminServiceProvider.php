<?php

namespace Chunker\Admin;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
	public function boot()
	{
		$this->commands([
			Commands\Clear::class
		]);

		$this->publishes([
			__DIR__ . '/migrations' => database_path('migrations')
		], 'migrations');
	}


	public function register()
	{
		//
	}
}