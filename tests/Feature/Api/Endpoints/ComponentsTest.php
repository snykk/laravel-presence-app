<?php

namespace Tests\Feature\Api\Endpoints;

use App\Models\Component;
use App\Models\User;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ComponentsTest extends TestCase
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
    protected $endpoint = '/api/en/components/';

    /**
     * Faker generator instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * The model which being tested.
     *
     * @var Component
     */
    protected $model;

    /**
     * Setup the test environment.
     *
     * return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->model = Component::factory()->create();
    }

    /** @test */
    public function index_endpoint_works_as_expected()
    {
        $this->getJson($this->endpoint)
            ->assertStatus(200)
            ->assertJsonFragment([
                'name'  => $this->model->getAttribute('name'),
                'slug'  => $this->model->getAttribute('slug'),
                'order' => $this->getCastedAttribute('order'),
                'type'  => $this->model->getAttribute('type'),
            ]);
    }

    /** @test */
    public function show_endpoint_works_as_expected()
    {
        $this->getJson($this->endpoint.$this->model->slug)
            ->assertStatus(200)
            ->assertJsonFragment([
                'name'  => $this->model->getAttribute('name'),
                'slug'  => $this->model->getAttribute('slug'),
                'order' => $this->getCastedAttribute('order'),
                'type'  => $this->model->getAttribute('type'),
            ]);
    }
}
