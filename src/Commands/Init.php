<?php

namespace Chunker\Base\Commands;

use Illuminate\Console\Command;

class Init extends Command
{
	protected $signature = 'chunker:init';
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


		// Replacing locale in app config
		if ($this->replaceInConfig('app', 'UTC', 'Europe/Moscow'))
		{
			$this->line('Locale set for Europe/Moscow');
		}


		// Replacing user's model class in auth config
		if ($this->replaceInConfig('auth', 'App\User::class', 'Chunker\Base\Models\User::class'))
		{
			$this->line('Class of User\'s model has been replaced in auth config');
		}
	}


	protected function replaceInConfig($config, $oldString, $newString)
	{
		$filename = config_path($config . '.php');
		$content = file_get_contents($filename);

		if (mb_strpos($content, $oldString) !== false)
		{
			$content = str_replace($oldString, $newString, $content);
			file_put_contents($filename, $content);

			return true;
		}

		return false;
	}
}