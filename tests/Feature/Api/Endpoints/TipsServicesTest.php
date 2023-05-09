<?php

namespace Tests\Feature\Api\Endpoints;

use App\Models\TipsService;
use App\Models\User;
use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TipsServicesTest extends TestCase
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
    protected $endpoint = '/api/en/tips_services';

    /**
     * Faker generator instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * The model which being tested.
     *
     * @var TipsService
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

        $this->model = TipsService::factory()->create([
            'published_at' => Carbon::yesterday(),
        ]);
    }

    /** @test */
    public function index_endpoint_works_as_expected()
    {
        $this->getJson($this->endpoint)
            ->assertStatus(200)
            ->assertJsonFragment([
                'image_type' => $this->model->getAttribute('image_type'),
                'order'      => $this->getCastedAttribute('order'),
            ]);
    }
}
