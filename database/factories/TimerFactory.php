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


    return [


        'workspaceID' => 1,
        'projectID' => 1, //default to one, but this should be over ridden on creation
        'userID' => 1, //default to one, but this should be over ridden on creation
        'clientID' => 1, //default to one, but this should be over ridden on creation
        'startTime' => $faker->dateTime,
        'endTime' => $faker->dateTime,
        'description' => $faker->paragraph,
        'billable' => true,
    ];
});