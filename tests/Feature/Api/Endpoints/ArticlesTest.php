<?php

namespace Tests\Feature\Api\Endpoints;

use App\Models\Article;
use App\Models\User;
use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ArticlesTest extends TestCase
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
    protected $endpoint = '/api/en/articles/';

    /**
     * Faker generator instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * The model which being tested.
     *
     * @var Article
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

        $this->model = Article::factory()->create([
            'published_at' => Carbon::yesterday(),
        ]);
    }

    /** @test */
    public function index_endpoint_works_as_expected()
    {
        $this->getJson($this->endpoint)
            ->assertStatus(200)
            ->assertJsonFragment([
                'author'       => (string) $this->model->getAttribute('author'),
                'published_at' => $this->getCastedAttribute('published_at'),
            ]);
    }

    /** @test */
    public function show_endpoint_works_as_expected()
    {
        $this->getJson($this->endpoint.Article::first()->slug)
            ->assertStatus(200)
            ->assertJsonFragment([
                'author'       => (string) $this->model->getAttribute('author'),
                'published_at' => $this->getCastedAttribute('published_at'),
            ]);
    }
}
