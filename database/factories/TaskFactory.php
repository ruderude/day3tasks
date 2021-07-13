<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'mid' => "U8651de595ed52198a8a4c4b25b9c3187",
        'title' => $faker->name,
        'detail' => $faker->realText,
        'done' => $faker->numberBetween($min = 0, $max = 1),
        'created_at' => $faker->datetime($max = 'now', $timezone = date_default_timezone_get()),
    ];
});
