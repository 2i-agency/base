<?php

$factory->define(\Chunker\Base\Models\Notice::class, function (Faker\Generator $faker) {
	return [
		'content' => $faker->sentence(),
		'is_read' => $faker->boolean
	];
});