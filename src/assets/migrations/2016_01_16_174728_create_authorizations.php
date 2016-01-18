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
				->default(false);

			// Time of creating
			$table->timestamp('created_at');

		});
	}


	public function down()
	{
		Schema::drop('authorizations');
	}
}
