<?php

namespace Tests\Feature\Api\Endpoints;

use App\Models\Category;
use App\Models\Location;
use App\Models\Promo;
use App\Models\User;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PromosTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Currently logged in User.
     *
     * @var User
     */
    protected $user;

    /**
     * Current endpoint url which being tested.
     *
     * @var string
     */
    protected $endpoint = '/api/en/promos/';

    /**
     * Faker generator instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * The model which being tested.
     *
     * @var Promo
     */
    protected $model;

    /**
     * The location related to the model which being tested.
     *
     * @var Location
     */
    protected $location;

    /**
     * The category related to the model which being tested.
     *
     * @var Category
     */
    protected $category;

    /**
     * Setup the test environment.
     *
     * return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->location = Location::factory()->create();
        $this->category = Category::factory()->create();

        $this->model = Promo::factory()->create();

        $this->model->locations()->sync($this->location->id);
        $this->model->categories()->sync($this->category->id);
    }

    /**
     * Get contents from seller courier model for JSON assertions.
     *
     * @param bool $inJson
     *
     * @return array
     */
    private function getPromoContents(bool $inJson = false): array
    {
        return [
            'brand_id'    => $this->getCastedAttribute('brand_id'),
            'rank'        => $this->getCastedAttribute('rank'),
            'cta_url'     => $this->getCastedAttribute('cta_url'),
            'start_date'  => $this->model->start_date,
            'end_date'    => $this->model->end_date,
        ];
    }

    /** @test */
    public function index_endpoint_works_as_expected()
    {
        $this->getJson($this->endpoint)
            ->assertStatus(200)
            ->assertJsonFragment($this->getPromoContents());
    }

    /** @test */
    public function show_endpoint_works_as_expected()
    {
        $this->getJson($this->endpoint.Promo::first()->slug)
            ->assertStatus(200)
            ->assertJsonFragment($this->getPromoContents())
            ->assertJsonStructure(['data', 'sibling']);
    }
}
