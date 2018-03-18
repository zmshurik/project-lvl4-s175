<?php

use Faker\Generator as Faker;

$factory->define(\App\Task::class, function (Faker $faker) {
    return [
        'name' => 'task name',
        'description' => 'descript'
    ];
});
