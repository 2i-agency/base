<?php

$factory->define(\Chunker\Base\Models\NoticesType::class, function (Faker\Generator $faker) {
	return [
		'tag' => $faker->unique()->word,
		'name' => $faker->words(3, true)
	];
});