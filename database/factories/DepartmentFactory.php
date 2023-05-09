<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DepartmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Department::class;

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

            'code' => $code,
            'name' => [
                'en' => $this->faker->sentence(rand(1, 3)),
                'id' => $this->faker->sentence(rand(1, 3)),
            ],
            'description' => [
                'en' => $this->faker->sentence(rand(6, 10)),
                'id' => $this->faker->sentence(rand(6, 10)),
            ],
        ];
    }
}
