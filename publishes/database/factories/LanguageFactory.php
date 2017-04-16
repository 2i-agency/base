<?php

$factory->define(\Chunker\Base\Models\Language::class, function (Faker\Generator $faker) {
	$locale = $faker->unique(true)->languageCode;

	return [
		'name' => strtoupper($locale),
		'locale' => $locale,
		'is_published' => $faker->boolean,
	];
});