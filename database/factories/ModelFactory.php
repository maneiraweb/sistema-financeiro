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

$factory->define(SisFin\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->state(SisFin\Models\User::class, 'admin', function (Faker\Generator $faker) {
    return [
        'role' => \SisFin\Models\User::ROLE_ADMIN
    ];
});

$factory->define(SisFin\Models\ContaBancaria::class, function (Faker\Generator $faker) {
    return [
        'nome' => $faker->city,
        'agencia' => rand(10000, 60000). '-' .rand(0, 9),
        'conta' => rand(70000, 260000). '-' .rand(0, 9),
    ];
});

$factory->define(SisFin\Models\Cliente::class, function (Faker\Generator $faker) {
    return [
        'nome' => $faker->name
    ];
});

$factory->define(SisFin\Models\CategoryRevenue::class, function (Faker\Generator $faker) {
    return [
        'nome' => $faker->name
    ];
});

$factory->define(SisFin\Models\CategoryExpense::class, function (Faker\Generator $faker) {
    return [
        'nome' => $faker->name
    ];
});

$factory->define(SisFin\Models\BillPay::class, function (Faker\Generator $faker) {
    return [
        'date_due' => $faker->date(),
        'name' => $faker->word,
        'value' => $faker->numberBetween(10, 1000),
        'done' => rand(0,1)
    ];
});

