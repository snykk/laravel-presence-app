<?php

namespace Database\Factories;

use App\Models\StaticPage;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StaticPageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StaticPage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $nameEn = $this->faker->text(rand(30, 160));
        $nameId = $this->faker->text(rand(30, 160));

        return [
            'layout'        => 'default',
            'published_at'  => Carbon::yesterday(),
            'name'          => [
                'en' => $nameEn,
                'id' => $nameId,
            ],
            'slug'          => [
                'en' => Str::slug($nameEn),
                'id' => Str::slug($nameId),
            ],
            'content'       => [
                'en' => $this->faker->randomHtml(),
                'id' => $this->faker->randomHtml(),
            ],
            'youtube_video' => [
                'en' => null,
                'id' => null,
            ],
        ];
    }
}
