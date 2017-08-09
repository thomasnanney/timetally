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
    $dayOffset = rand(0, 10);
    $hourOffset1 = rand(0,22);
    $hourOffset2 = rand(0,8);
    $startTime = new DateTime('now', new DateTimeZone('UTC'));
    $startTime->sub(new DateInterval('P'.$dayOffset.'D'));
    $startTime->sub(new DateInterval('PT'.$hourOffset1.'H'));
    $startTime->format('Y-m-d H:i:s');
    $endTime = clone $startTime;
    $endTime->add(new DateInterval('PT'.$hourOffset2.'H'));

    return [
        'projectID' => 1, //default to one, but this should be over ridden on creation
        'userID' => 1, //default to one, but this should be over ridden on creation
        'startTime' => $startTime,
        'endTime' => $endTime,
        'description' => $faker->sentence(4),
        'billable' => rand(0,1) ? true : false,
        'clientID' => 1,
        'workspaceID' => 1
    ];
});