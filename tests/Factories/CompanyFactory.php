<?php

use Hypefactors\Laravel\Follow\Tests\Stubs\CompanyStub;

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(CompanyStub::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});
