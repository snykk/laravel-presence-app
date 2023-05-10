<?php

namespace Database\Factories;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Schedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'seq' => $this->faker->numberBetween(0, 30000),
            'start_time' => Carbon::now()->subDays(rand(1, 60))->addHours(rand(1, 12))->addMinutes(rand(1, 30))->addSeconds(rand(1, 30)),
            'end_time' => Carbon::now()->subDays(rand(1, 60))->addHours(rand(1, 12))->addMinutes(rand(1, 30))->addSeconds(rand(1, 30)),

        ];
    }
}
