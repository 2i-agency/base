<?php

namespace Chunker\Base\Commands;

use Illuminate\Console\Command;

class Clear extends Command
{
	protected $signature = 'chunker:clear';
	protected $description = 'Clear files which will be replaced by Chunker';


	public function handle()
	{
		$files = [
			// Old users migration
			database_path('migrations/2014_10_12_000000_create_users_table.php')
		];

		foreach ($files as $file)
		{
			if (file_exists($file))
			{
				unlink($file);
			}
		}

		$this->line('Unnecessary files deleted');


		// Replacing class in auth config
		$auth_config_filename = config_path('auth.php');
		$auth_config_content = file_get_contents($auth_config_filename);
		$auth_config_content = str_replace('App\User::class', 'Chunker\Base\Models\User::class', $auth_config_content);
		file_put_contents($auth_config_filename, $auth_config_content);

		$this->line('Class of User\'s model has been replaced in auth config');
	}
}