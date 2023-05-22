<?php

namespace Database\Factories;

use App\Models\Building;
use App\Models\Classroom;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ClassroomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Classroom::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'building_id' => Building::factory(),
            'room_number' => $this->faker->randomLetter(),
            'capacity' => $this->faker->numberBetween(45, 55),
            'floor' => $this->faker->numberBetween(0, 30),
            'status' => $this->faker->randomElement([Classroom::STATUS_ACTIVE, Classroom::STATUS_UNDER_MAINTENANCE]),

        ];
    }
}
