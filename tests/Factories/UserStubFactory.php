<?php

namespace Hypefactors\Laravel\Follow\Tests\Factories;

use Hypefactors\Laravel\Follow\Tests\Stubs\UserStub;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserStubFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserStub::class;

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
