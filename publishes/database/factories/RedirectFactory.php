<?php

$factory->define(\Chunker\Base\Models\Redirect::class, function (Faker\Generator $faker) {
	return [
		'from' => '/' . $faker->unique()->word,
		'to' => $faker->url,
		'comment' => $faker->sentence(3),
		'is_active' => $faker->boolean
	];
});