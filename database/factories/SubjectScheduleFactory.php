<?php

namespace Database\Factories;

use App\Models\Schedule;
use App\Models\Subject;
use App\Models\SubjectSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SubjectScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SubjectSchedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'subject_id' => Subject::factory(),
            'schedule_id' => Schedule::factory(),


        ];
    }
}
