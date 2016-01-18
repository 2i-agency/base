<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration
{
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {

			$table->engine = 'MyISAM';

			// ID
			$table->increments('id');

			// Login
			$table
				->string('login')
				->unique();

			// Password's hash
			$table->string('password', 60);

			// Remember token
			$table->rememberToken();

			// Email
			$table
				->string('email')
				->index();

			// Name
			$table
				->string('name')
				->nullable();

			// Creator's ID
			$table
				->integer('creator_id')
				->index()
				->unsigned()
				->nullable();

			// Updater's ID
			$table
				->integer('updater_id')
				->index()
				->unsigned()
				->nullable();

			// Time of creating and updating
			$table->timestamps();

			// Time of deleting
			$table->softDeletes();

		});
	}


	public function down()
	{
		Schema::drop('users');
	}
}
