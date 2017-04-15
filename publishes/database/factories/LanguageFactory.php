<?php

$factory->define(\Chunker\Base\Models\Language::class, function (Faker\Generator $faker) {
	$locale = $faker->unique()->languageCode;

	return [
		'name' => strtoupper($locale),
		'locale' => $locale,
		'is_published' => $faker->boolean,
	];
});