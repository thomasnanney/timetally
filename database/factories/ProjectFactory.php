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

    $scopes =[
        'public',
        'private'
    ];

    $billableHourlyType = [
        'project',
        'employee'
    ];

    $billableTypes = [
        'hourly',
        'fixed'
    ];

    return [
        'description' => $faker->paragraph,
        'clientID' => 1, //default to one, but this should be over ridden on creation
        'workspaceID' => 1,
        'billableType' => $billableTypes[rand(0,1)],
        'projectedRevenue' => $faker->numberBetween(0,10000),
        'scope' => 'public', //$scopes[rand(0, 1)],
        'title' => $faker->word,
        'startDate' => $faker->dateTime,
        'endDate' => $faker->dateTime,
        'projectedTime' => $faker->randomDigitNotNull,
        'billableHourlyType' => $billableHourlyType[rand(0, 1)],
        'billableRate' => $faker->numberBetween(0,1000),
    ];
});
