<?php

namespace Database\Factories;

use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Program::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'Title' => 'Program ' . $this->faker->unique()->numberBetween(1, 100000),
            'Description' => 'A program',
            'Excerpt' => 'A program',
            'Vendor Contact' => $this->faker->companyEmail,
            'Exclusive' => false,
            'Vendor Approval' => false,
        ];
    }
}
