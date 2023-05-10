<?php

namespace Tests\Feature\Api\Endpoints;

use App\Models\User;
use App\Models\Subject;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SubjectsTest extends TestCase
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
    protected $endpoint = '/api/subjects/';

    /**
     * Faker generator instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * The model which being tested.
     *
     * @var Subject
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

        $this->model = Subject::factory()->create();
    }

    /** @test */
    public function index_endpoint_works_as_expected()
    {
        $this->getJson($this->endpoint)
            ->assertStatus(200)
            ->assertJsonFragment([
                'department_id' => $this->model->getAttribute('department_id'),
                'code' => $this->model->getAttribute('code'),
                'score_credit' => $this->model->getAttribute('score_credit'),
            ]);
    }

    /** @test */
    public function show_endpoint_works_as_expected()
    {
        $this->getJson($this->endpoint.$this->model->getKey())
            ->assertStatus(200)
            ->assertJsonFragment([
                'department_id' => $this->model->getAttribute('department_id'),
                'code' => $this->model->getAttribute('code'),
                'score_credit' => $this->model->getAttribute('score_credit'),
            ]);
    }

    /** @test */
    public function create_endpoint_works_as_expected()
    {
        // Submitted data
        $data = Subject::factory()->raw();

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
        $data = Subject::factory()->raw();

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
                'info' => 'The subject has been deleted.',
            ]);

        $this->assertDatabaseHas('subjects', [
            'department_id' => $this->model->getAttribute('department_id'),
            'code' => $this->model->getAttribute('code'),
            'score_credit' => $this->model->getAttribute('score_credit'),
        ]);

        $this->assertDatabaseMissing('subjects', [
            'department_id' => $this->model->getAttribute('department_id'),
            'code' => $this->model->getAttribute('code'),
            'score_credit' => $this->model->getAttribute('score_credit'),
            'deleted_at' => null,
        ]);
    }
}
