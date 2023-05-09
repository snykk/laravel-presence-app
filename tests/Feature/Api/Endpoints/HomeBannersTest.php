<?php

namespace Tests\Feature\Api\Endpoints;

use App\Models\HomeBanner;
use App\Models\User;
use DB;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class HomeBannersTest extends TestCase
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
    protected $endpoint = '/api/id/home_banners/';

    /**
     * Faker factory instance.
     *
     * @var \Faker\Factory
     */
    protected $factory;

    /**
     * The model which being tested.
     *
     * @var HomeBanner
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

        $this->factory = Factory::create();
        $this->model = HomeBanner::factory()->create(['rank' => 1]);
    }

    /** @test */
    public function index_endpoint_works_as_expected()
    {
        $this->getJson($this->endpoint)
            ->assertStatus(200)
            ->assertJsonFragment([
                'id'    => $this->model->id,
                'rank'  => (string) $this->model->getAttribute('rank'),
                'title' => $this->model->getAttribute('title'),
                'url'   => (string) $this->model->getAttribute('url'),
            ]);
    }

    /** @test */
    public function index_endpoint_wont_show_home_banner_with_no_media()
    {
        DB::table('media')->truncate();
        $this->getJson($this->endpoint)
            ->assertStatus(200)
            ->assertJsonMissing([
                'id'    => $this->model->id,
                'rank'  => (string) $this->model->getAttribute('rank'),
                'title' => $this->model->getAttribute('title'),
                'url'   => (string) $this->model->getAttribute('url'),
            ]);
    }

    /** @test */
    public function index_endpoint_wont_show_home_banner_that_has_zero_as_rank()
    {
        $this->model->update(['rank' => 0]);
        $this->getJson($this->endpoint)
            ->assertStatus(200)
            ->assertJsonMissing([
                'id'    => $this->model->id,
                'rank'  => (string) $this->model->getAttribute('rank'),
                'title' => $this->model->getAttribute('title'),
                'url'   => (string) $this->model->getAttribute('url'),
            ]);
    }
}
