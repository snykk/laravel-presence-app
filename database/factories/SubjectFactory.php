<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SubjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subject::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Generate a pattern with 3 alpha and 4 numeric characters
        $code = sprintf('%s%04d', substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3), mt_rand(0, 9999));

        return [
            'department_id' => Department::factory(),
            'code' => $code,
            'score_credit' => $this->faker->numberBetween(1, 3),
            'title' => [
                'en' => $this->faker->sentence(rand(2, 4)),
                'id' => $this->faker->sentence(rand(2, 4)),
            ],
        ];
    }
}
