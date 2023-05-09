<?php

namespace Tests\Feature\Api\Endpoints;

use App\Models\Menu;
use App\Models\User;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class MenusTest extends TestCase
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
    protected $endpoint = '/api/id/menus/';

    /**
     * Faker generator instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * The model which being tested.
     *
     * @var Menu
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

        $this->seed(['PermissionSeeder', 'RoleSeeder']);

        $this->faker = new Generator();
        $this->model = Menu::factory()->create([
            'published_at' => now(),
        ]);
    }

    /** @test */
    public function index_endpoint_works_as_expected()
    {
        $this->getJson($this->endpoint)
            ->assertStatus(200)
            ->assertJsonFragment([
                'id'    => $this->model->getAttribute('id'),
                'order' => (string) $this->model->getAttribute('order'),
                'title' => $this->model->getAttribute('title'),
                'url'   => $this->model->getAttribute('url'),
            ]);
    }

    /** @test */
    public function index_endpoint_wont_show_unpublished_menus()
    {
        $this->model->update(['deleted_at' => null]);
        $this->getJson($this->endpoint)
            ->assertStatus(200)
            ->assertJsonFragment([
                'id'    => $this->model->getAttribute('id'),
                'order' => (string) $this->model->getAttribute('order'),
                'title' => $this->model->getAttribute('title'),
                'url'   => $this->model->getAttribute('url'),
            ]);
    }
}
