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
$factory->define(App\Projects\Models\Project::class, function (Faker\Generator $faker) {



    return [
        'description' => $faker->paragraph(2, true),
        'clientID' => 1, //default to one, but this should be over ridden on creation
        'workspaceID' => 1,
        'projectedRevenue' => $faker->numberBetween(0,2000000),
        'projectedCost' => $faker->numberBetween(0,100000),
        'private' => rand(0, 1),
        'title' => $faker->word,
        'startDate' => $faker->date('Y-m-d'),
        'endDate' => $faker->date('Y-m-d'),
        'projectedTime' => $faker->randomDigitNotNull,
    ];
});
