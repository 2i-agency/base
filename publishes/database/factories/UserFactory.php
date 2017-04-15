<?php

$factory->define(\Chunker\Base\Models\User::class, function(Faker\Generator $faker) {
	return [
		'login'         => $faker->unique()->userName,
		'password'      => '000000',
		'email'         => $faker->unique()->email,
		'name'          => $faker->unique()->name,
		'is_subscribed' => $faker->boolean,
		'is_admin'      => $faker->boolean(20)
	];
});
