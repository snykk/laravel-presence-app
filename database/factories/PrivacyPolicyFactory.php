<?php

namespace Database\Factories;

use App\Models\PrivacyPolicy;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrivacyPolicyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PrivacyPolicy::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'slug'         => $this->faker->slug(6),
            'order'        => $this->faker->numberBetween(0, 99999),
            'published_at' => Carbon::now()->subDays(rand(1, 60))->addHours(rand(1, 12))->addMinutes(rand(1, 30))->addSeconds(rand(1, 30)),

        ];
    }
}
