<?php

namespace Tests\Feature\Api\Endpoints;

use App\Models\User;
use App\Models\Classroom;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ClassroomsTest extends TestCase
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
    protected $endpoint = '/api/classrooms/';

    /**
     * Faker generator instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * The model which being tested.
     *
     * @var Classroom
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

        $this->model = Classroom::factory()->create();
    }

    /** @test */
    public function index_endpoint_works_as_expected()
    {
        $this->getJson($this->endpoint)
            ->assertStatus(200)
            ->assertJsonFragment([
                'building_id' => $this->model->getAttribute('building_id'),
                'room_number' => $this->model->getAttribute('room_number'),
                'capacity' => $this->model->getAttribute('capacity'),
                'floor' => $this->model->getAttribute('floor'),
                'status' => $this->model->getAttribute('status'),
            ]);
    }

    /** @test */
    public function show_endpoint_works_as_expected()
    {
        $this->getJson($this->endpoint.$this->model->getKey())
            ->assertStatus(200)
            ->assertJsonFragment([
                'building_id' => $this->model->getAttribute('building_id'),
                'room_number' => $this->model->getAttribute('room_number'),
                'capacity' => $this->model->getAttribute('capacity'),
                'floor' => $this->model->getAttribute('floor'),
                'status' => $this->model->getAttribute('status'),
            ]);
    }

    /** @test */
    public function create_endpoint_works_as_expected()
    {
        // Submitted data
        $data = Classroom::factory()->raw();

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
        $data = Classroom::factory()->raw();

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
                'info' => 'The classroom has been deleted.',
            ]);

        $this->assertDatabaseHas('classrooms', [
            'building_id' => $this->model->getAttribute('building_id'),
            'room_number' => $this->model->getAttribute('room_number'),
            'capacity' => $this->model->getAttribute('capacity'),
            'floor' => $this->model->getAttribute('floor'),
            'status' => $this->model->getAttribute('status'),
        ]);

        $this->assertDatabaseMissing('classrooms', [
            'building_id' => $this->model->getAttribute('building_id'),
            'room_number' => $this->model->getAttribute('room_number'),
            'capacity' => $this->model->getAttribute('capacity'),
            'floor' => $this->model->getAttribute('floor'),
            'status' => $this->model->getAttribute('status'),
            'deleted_at' => null,
        ]);
    }
}
