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
    static $password;

    return [
        'id' => $faker->randomDigitNotNull,
        'description' => $faker->paragraph,
        'clientID' => $faker->randomDigitNotNull,
        'billableType' => 'byProject',
        'projectedRevenue' => $faker->numberBetween(0,1000),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'scope' => 'public',
        'billableHourlyType' => $faker->word,
        'billableRate' => $faker->numberBetween(0,1000),
    ];
});
