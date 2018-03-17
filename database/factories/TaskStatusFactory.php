<?php

use Faker\Generator as Faker;
use App\TaskStatus;

$factory->define(TaskStatus::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
    ];
});
