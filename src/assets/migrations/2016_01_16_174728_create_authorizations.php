<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorizations extends Migration
{
	public function up()
	{
		Schema::create('authorizations', function (Blueprint $table) {

			$table->engine = 'MyISAM';

			// ID
			$table->increments('id');

			// User's ID
			$table
				->integer('user_id')
				->unsigned()
				->index();

			// Agent's string
			$table->string('user_agent');

			// IP address
			$table
				->bigInteger('ip_address')
				->unsigned();

			// Error flag
			$table
				->boolean('failed')
				->default(false)
				->index();

			// Time of login
			$table
				->timestamp('logged_in_at')
				->index();

			// Time of last request
			$table
				->timestamp('last_request_at')
				->nullable()
				->index();

		});
	}


	public function down()
	{
		Schema::drop('authorizations');
	}
}
