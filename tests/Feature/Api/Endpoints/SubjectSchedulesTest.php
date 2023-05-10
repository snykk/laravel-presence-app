<?php

namespace Tests\Feature\Api\Endpoints;

use App\Models\User;
use App\Models\SubjectSchedule;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SubjectSchedulesTest extends TestCase
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
    protected $endpoint = '/api/subject_schedules/';

    /**
     * Faker generator instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * The model which being tested.
     *
     * @var SubjectSchedule
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

        $this->model = SubjectSchedule::factory()->create();
    }

    /** @test */
    public function index_endpoint_works_as_expected()
    {
        $this->getJson($this->endpoint)
            ->assertStatus(200)
            ->assertJsonFragment([
                'subject_id' => $this->model->getAttribute('subject_id'),
                'schedule_id' => $this->model->getAttribute('schedule_id'),
            ]);
    }

    /** @test */
    public function show_endpoint_works_as_expected()
    {
        $this->getJson($this->endpoint.$this->model->getKey())
            ->assertStatus(200)
            ->assertJsonFragment([
                'subject_id' => $this->model->getAttribute('subject_id'),
                'schedule_id' => $this->model->getAttribute('schedule_id'),
            ]);
    }

    /** @test */
    public function create_endpoint_works_as_expected()
    {
        // Submitted data
        $data = SubjectSchedule::factory()->raw();

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
        $data = SubjectSchedule::factory()->raw();

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
                'info' => 'The subject schedule has been deleted.',
            ]);

        $this->assertDatabaseHas('subject_schedules', [
            'subject_id' => $this->model->getAttribute('subject_id'),
            'schedule_id' => $this->model->getAttribute('schedule_id'),
        ]);

        $this->assertDatabaseMissing('subject_schedules', [
            'subject_id' => $this->model->getAttribute('subject_id'),
            'schedule_id' => $this->model->getAttribute('schedule_id'),
            'deleted_at' => null,
        ]);
    }
}
