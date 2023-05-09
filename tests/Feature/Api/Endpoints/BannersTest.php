<?php

namespace Tests\Feature\Api\Endpoints;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Location;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class BannersTest extends TestCase
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
    protected $endpoint = '/api/id/banners?append=promo_slug';

    /**
     * Faker generator instance.
     *
     * @var \Faker\Factory
     */
    protected $factory;

    /**
     * The model which being tested.
     *
     * @var Banner
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

        $this->model = Banner::factory()->create([
            'rank' => 2,
        ]);
        $this->model
            ->addMediaFromUrl($this->factory->imageUrl())
            ->toMediaCollection(Banner::IMAGE_COLLECTION.'-en');

        $location = Location::factory()->create();
        $category = Category::factory()->create();

        $this->model->promo->locations()->sync($location->id);
        $this->model->promo->categories()->sync($category->id);
    }

    private function getBannerContents(): array
    {
        return [
            'id'             => $this->model->id,
            'rank'           => (string) $this->model->getAttribute('rank'),
            'promo_id'       => (string) $this->model->getAttribute('promo_id'),
            'promo_slug'     => $this->model->promo->slug,
            'standalone_url' => (string) $this->model->standalone_url,
        ];
    }

    /** @test */
    public function index_endpoint_works_as_expected()
    {
        $response = $this->getJson($this->endpoint);
        $response->assertStatus(200)
            ->assertJsonFragment($this->getBannerContents());
    }

    /** @test */
    public function index_endpoint_wont_show_banner_with_no_media()
    {
        DB::table('media')->truncate();
        $this->getJson($this->endpoint)
            ->assertStatus(200)
            ->assertJsonMissing($this->getBannerContents());
    }

    /** @test */
    public function index_endpoint_will_show_to_be_active_promo_banner()
    {
        $this->model->promo->update([
            'start_date'    => Carbon::today()->subDays(rand(1, 60))->addYear(),
            'end_date'      => Carbon::today()->addDays(rand(1, 60))->addYear(),
        ]);
        $this->getJson($this->endpoint)
            ->assertStatus(200)
            ->assertJsonFragment($this->getBannerContents());
    }

    /** @test */
    public function index_endpoint_wont_show_expired_promo_banner()
    {
        $this->model->promo->update([
            'start_date'    => Carbon::today()->subDays(rand(1, 60))->subYear(),
            'end_date'      => Carbon::today()->addDays(rand(1, 60))->subYear(),
        ]);
        $this->getJson($this->endpoint)
            ->assertStatus(200)
            ->assertJsonMissing($this->getBannerContents());
    }

    /** @test */
    public function index_endpoint_wont_show_promo_banner_that_has_incomplete_promo_data()
    {
        $this->model->promo->brand->delete();
        $this->getJson($this->endpoint)
            ->assertStatus(200)
            ->assertJsonMissing($this->getBannerContents());
    }

    /** @test */
    public function index_endpoint_wont_show_banner_that_has_zero_as_rank()
    {
        $this->model->update(['rank' => 0]);
        $this->getJson($this->endpoint)
            ->assertStatus(200)
            ->assertJsonMissing($this->getBannerContents());
    }
}
