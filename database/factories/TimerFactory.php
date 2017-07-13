<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Timer\Models\TimeEntries::class, function (Faker\Generator $faker) {

    $hours = rand(2, 6);
    $offset = rand(0, 10);
    $startTime = date('Y-m-d H:i:s', strtotime('-'.$offset.' day', time()));
    $endTime = date('Y-m-d H:i:s', strtotime('+'.$hours.' hour', strtotime($startTime)));

    return [
        'projectID' => 1, //default to one, but this should be over ridden on creation
        'userID' => 1, //default to one, but this should be over ridden on creation
        'startTime' => $startTime,
        'endTime' => $endTime,
        'description' => $faker->sentence(4),
        'billable' => rand(0,1) ? true : false,
    ];
});