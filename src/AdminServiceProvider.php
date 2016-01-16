<?php

namespace Chunker\Admin;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
	public function boot()
	{
		// Commands of package
		$this->commands([
			Commands\Clear::class
		]);


		// Routes
		require_once __DIR__ . '/routes.php';


		// Views
		$this->loadViewsFrom(__DIR__ . '/views', 'Admin');


		// Assets of packages
		$this->publishes([__DIR__ . '/migrations' => database_path('migrations')], 'migrations');
		$this->publishes([__DIR__ . '/config' => config_path()], 'config');
		$this->publishes([__DIR__ . '/assets' => storage_path('app/admin')], 'assets');
		$this->publishes([__DIR__ . '/views' => base_path('resources/views/admin')], 'views');
	}


	public function register()
	{
		//
	}
}