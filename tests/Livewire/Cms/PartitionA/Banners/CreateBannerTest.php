<?php

namespace Tests\Livewire\Cms\PartitionA\Banners;

use App\Models\Admin;
use App\Models\Banner;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Livewire\WithFileUploads;
use Tests\CmsTests;
use Tests\TestCase;

class CreateBannerTest extends TestCase
{
    use CmsTests;
    use DatabaseMigrations;
    use WithFileUploads;

    /**
     * Cms Admin Object.
     *
     * @var \App\Models\Admin
     */
    protected Admin $admin;

    /**
     * Faker object.
     *
     * @var \Faker\Generator
     */
    protected Generator $faker;

    /**
     * Setup the test environment.
     *
     * return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->seed(['PermissionSeeder', 'RoleSeeder']);

        $this->admin = Admin::factory()->create()->assignRole('super-administrator');

        $this->actingAs($this->admin, config('cms.guard'));

        $this->faker = Factory::create();
    }

    /** @test */
    public function create_component_is_accessible()
    {
        Livewire::test('cms.banners.create-banner')
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_not_save_the_new_banner_record_without_an_image()
    {
        $data = $this->fakeRawData(Banner::class);
        $translations = $this->fakeTranslationData(Banner::class);

        Livewire::test('cms.banners.create-banner')
            ->set('banner.rank', $data['rank'])
            ->set('banner.promo_id', $data['promo_id'])
            ->set('translations.standalone_url.en', $translations['en']['standalone_url'])
            ->set('translations.standalone_url.id', $translations['id']['standalone_url'])
            ->set('isMainBanner', ($data['is_main_banner']) ? 'true' : 'false')
            ->call('save')
            ->assertHasErrors();

        $this->assertDatabaseMissing('banners', $data);
        $this->assertDatabaseMissing('banner_translations', $translations['en']);
        $this->assertDatabaseMissing('banner_translations', $translations['id']);
    }

    /** @test */
    public function it_can_cancel_creating_new_banner_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(Banner::class);
        $translations = $this->fakeTranslationData(Banner::class);

        Livewire::test('cms.banners.create-banner')
            ->set('banner.rank', $data['rank'])
            ->set('banner.promo_id', $data['promo_id'])
            ->set('translations.standalone_url.en', $translations['en']['standalone_url'])
            ->set('translations.standalone_url.id', $translations['id']['standalone_url'])
            ->set('isMainBanner', ($data['is_main_banner']) ? 'true' : 'false')
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/banners');

        $this->assertDatabaseMissing('banners', $data);
        $this->assertDatabaseMissing('banner_translations', $translations['en']);
        $this->assertDatabaseMissing('banner_translations', $translations['id']);
    }
}
