<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Project::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'client_id' => function () {
            return factory(\App\Client::class)->create()->id;
        }
    ];
});
