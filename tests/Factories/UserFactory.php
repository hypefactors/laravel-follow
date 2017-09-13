<?php

use Hypefactors\Laravel\Follow\Tests\Stubs\UserStub;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(UserStub::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});
