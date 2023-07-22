<?php

namespace Hypefactors\Laravel\Follow\Tests\Factories;

use Hypefactors\Laravel\Follow\Tests\Stubs\CompanyStub;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyStubFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CompanyStub::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}
