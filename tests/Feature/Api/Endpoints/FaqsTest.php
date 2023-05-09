<?php

namespace Tests\Feature\Api\Endpoints;

use App\Models\Faq;
use App\Models\User;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FaqsTest extends TestCase
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
    protected $endpoint = '/api/faqs/';

    /**
     * Faker generator instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * The model which being tested.
     *
     * @var Faq
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
        $this->user = User::factory()->create()->assignRole('super-administrator');

        $this->actingAs($this->user, config('api.cms_guard'));

        $this->model = Faq::factory()->create();
    }

    /** @test */
    public function index_endpoint_works_as_expected()
    {
        $this->getJson($this->endpoint)
            ->assertStatus(200)
            ->assertJsonFragment([
                'order'        => $this->model->getAttribute('order'),
                'slug'         => $this->model->getAttribute('slug'),
                'published_at' => $this->model->getAttribute('published_at'),
            ]);
    }

    /** @test */
    public function show_endpoint_works_as_expected()
    {
        $this->getJson($this->endpoint.$this->model->getKey())
            ->assertStatus(200)
            ->assertJsonFragment([
                'order'        => $this->model->getAttribute('order'),
                'slug'         => $this->model->getAttribute('slug'),
                'published_at' => $this->model->getAttribute('published_at'),
            ]);
    }

    /** @test */
    public function create_endpoint_works_as_expected()
    {
        // Submitted data
        $data = Faq::factory()->raw();

        // The data which should be shown
        $seenData = $data;

        $this->postJson($this->endpoint, $data)
            ->assertStatus(201)
            ->assertJsonFragment($seenData);
    }

    /** @test */
    public function update_endpoint_works_as_expected()
    {
        // Submitted data
        $data = Faq::factory()->raw();

        // The data which should be shown
        $seenData = $data;

        $this->patchJson($this->endpoint.$this->model->getKey(), $data)
            ->assertStatus(200)
            ->assertJsonFragment($seenData);
    }

    /** @test */
    public function delete_endpoint_works_as_expected()
    {
        $this->deleteJson($this->endpoint.$this->model->getKey())
            ->assertStatus(200)
            ->assertJsonFragment([
                'info' => 'The faq has been deleted.',
            ]);

        $this->assertDatabaseHas('faqs', [
            'order'        => $this->model->getAttribute('order'),
            'slug'         => $this->model->getAttribute('slug'),
            'published_at' => $this->model->getAttribute('published_at'),
        ]);

        $this->assertDatabaseMissing('faqs', [
            'order'        => $this->model->getAttribute('order'),
            'slug'         => $this->model->getAttribute('slug'),
            'published_at' => $this->model->getAttribute('published_at'),
            'deleted_at'   => null,
        ]);
    }
}
