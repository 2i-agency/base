<?php

namespace Chunker\Admin\Commands;

use Illuminate\Console\Command;

class Clear extends Command
{
	protected $signature = 'admin:clear';
	protected $description = 'Clear files which will be replaced by package \'Admin\'';


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
	}
}