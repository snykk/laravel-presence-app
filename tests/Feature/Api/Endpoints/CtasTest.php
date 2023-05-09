<?php

namespace Tests\Feature\Api\Endpoints;

use App\Models\Cta;
use App\Models\User;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CtasTest extends TestCase
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
    protected $endpoint = '/api/id/ctas/';

    /**
     * Faker generator instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * The model which being tested.
     *
     * @var Cta
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

        $this->model = Cta::factory()->create();
    }

    /** @test */
    public function index_endpoint_works_as_expected()
    {
        $this->getJson($this->endpoint)
            ->assertStatus(200)
            ->assertJsonFragment([
                'ctable_id'   => (string) $this->model->getAttribute('ctable_id'),
                'ctable_type' => $this->model->getAttribute('ctable_type'),
                'action_type' => $this->model->getAttribute('action_type'),
                'slug'        => $this->model->getAttribute('slug'),
            ]);
    }

    /** @test */
    public function show_endpoint_works_as_expected()
    {
        $this->getJson($this->endpoint.$this->model->getRouteKey())
            ->assertStatus(200)
            ->assertJsonFragment([
                'ctable_id'   => (string) $this->model->getAttribute('ctable_id'),
                'ctable_type' => $this->model->getAttribute('ctable_type'),
                'action_type' => $this->model->getAttribute('action_type'),
                'slug'        => $this->model->getAttribute('slug'),
            ]);
    }
}
