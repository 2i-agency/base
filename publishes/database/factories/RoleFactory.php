<?php

$factory->define(\Chunker\Base\Models\Role::class, function(Faker\Generator $faker) {
	return [ 'name' => $faker->unique()->jobTitle ];
});
