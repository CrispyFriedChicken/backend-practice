<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Faker\Factory as Factory;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->state(User::class, 'player', function () {
    return [
        'role' => \App\Enum\UserRoleEnum::PLAYER,
    ];
});
$factory->define(User::class, function (Faker $faker) {
    $twFaker = Factory::create('zh_TW');
    $enFaker = Factory::create('en');
    return [
        'uuid' => (string)Uuid::generate(4),
        'name' => $twFaker->name,
        'email' => $enFaker->unique()->email,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'currency' => $twFaker->randomElement(array_keys(\App\Models\Currency::getCodeTitleMap())),
    ];
});
