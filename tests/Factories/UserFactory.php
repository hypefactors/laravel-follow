<?php

use Hypefactors\Laravel\Follow\Tests\Stubs\UserStub;

$factory->define(UserStub::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});
