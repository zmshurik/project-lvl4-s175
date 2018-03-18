<?php

use Faker\Generator as Faker;

$factory->define(\App\Task::class, function (Faker $faker) {
    return [
        'name' => 'task name',
        'description' => 'descript',
        'status_id' => 1,
        'creator_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'assigned_to_id' => function () {
            return factory(\App\User::class)->create()->id;
        }
    ];
});
