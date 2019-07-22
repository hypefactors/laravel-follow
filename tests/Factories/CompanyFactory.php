<?php

use Hypefactors\Laravel\Follow\Tests\Stubs\CompanyStub;

$factory->define(CompanyStub::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});
