<?php

namespace Database\Factories;

use App\Models\Component;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class ComponentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Component::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->text(rand(128, 255));

        return [
            'published_at' => Carbon::now()->subDays(rand(1, 60))->addHours(rand(1, 12))->addMinutes(rand(1, 30))->addSeconds(rand(1, 30)),
            'name'         => $name,
            'slug'         => Str::slug($name),
            'type'         => 'default',
            'order'        => $this->faker->numberBetween(0, 99999),
            'title'        => [
                'en' => $this->faker->text(rand(250, 500)),
                'id' => $this->faker->text(rand(250, 500)),
            ],
            'description' => [
                'en' => $this->faker->text(rand(250, 500)),
                'id' => $this->faker->text(rand(250, 500)),
            ],
            'content' => [
                'en' => $this->faker->paragraph(5),
                'id' => $this->faker->paragraph(5),
            ],
        ];
    }
}
