<?php

namespace Tests\Feature\Api\Endpoints;

use App\Models\User;
use App\Models\Department;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DepartmentsTest extends TestCase
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
    protected $endpoint = '/api/departments/';

    /**
     * Faker generator instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * The model which being tested.
     *
     * @var Department
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

        $this->model = Department::factory()->create();
    }

    /** @test */
    public function index_endpoint_works_as_expected()
    {
        $this->getJson($this->endpoint)
            ->assertStatus(200)
            ->assertJsonFragment([
                'code' => $this->model->getAttribute('code'),
            ]);
    }

    /** @test */
    public function show_endpoint_works_as_expected()
    {
        $this->getJson($this->endpoint.$this->model->getKey())
            ->assertStatus(200)
            ->assertJsonFragment([
                'code' => $this->model->getAttribute('code'),
            ]);
    }

    /** @test */
    public function create_endpoint_works_as_expected()
    {
        // Submitted data
        $data = Department::factory()->raw();

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
        $data = Department::factory()->raw();

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
                'info' => 'The department has been deleted.',
            ]);

        $this->assertDatabaseHas('departments', [
            'code' => $this->model->getAttribute('code'),
        ]);

        $this->assertDatabaseMissing('departments', [
            'code' => $this->model->getAttribute('code'),
            'deleted_at' => null,
        ]);
    }
}
