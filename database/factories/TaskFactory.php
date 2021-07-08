<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'mid' => "U4658895cbcdab9ae7e442550d350ed99",
        'title' => $faker->title,
        'detail' => $faker->realText,
        'done' => $faker->numberBetween($min = 0, $max = 1),
        'created_at' => $faker->datetime($max = 'now', $timezone = date_default_timezone_get()),
    ];
});
