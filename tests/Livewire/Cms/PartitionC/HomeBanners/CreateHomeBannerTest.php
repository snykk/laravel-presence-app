<?php

namespace Tests\Livewire\Cms\PartitionC\HomeBanners;

use App\Models\Admin;
use App\Models\HomeBanner;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class CreateHomeBannerTest extends TestCase
{
    use CmsTests;
    use DatabaseMigrations;

    /**
     * Cms Admin Object.
     *
     * @var \App\Models\Admin
     */
    protected Admin $admin;

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
    }

    /** @test */
    public function create_component_is_accessible()
    {
        Livewire::test('cms.home-banners.create-home-banner')
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_not_save_the_new_home_banner_record_without_an_image()
    {
        $data = $this->fakeRawData(HomeBanner::class);
        $translations = $this->fakeTranslationData(HomeBanner::class);

        Livewire::test('cms.home-banners.create-home-banner')
            ->set('homeBanner.rank', $data['rank'])
            ->set('homeBanner.rank', $data['rank'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->set('translations.url.en', $translations['en']['url'])
            ->set('translations.url.id', $translations['id']['url'])
            ->call('save')
            ->assertHasErrors();

        $this->assertDatabaseMissing('home_banners', $data);
        $this->assertDatabaseMissing('home_banner_translations', $translations['en']);
        $this->assertDatabaseMissing('home_banner_translations', $translations['id']);
    }

    /** @test */
    public function it_can_cancel_creating_new_home_banner_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(HomeBanner::class);
        $translations = $this->fakeTranslationData(HomeBanner::class);

        Livewire::test('cms.home-banners.create-home-banner')
            ->set('homeBanner.rank', $data['rank'])
            ->set('homeBanner.rank', $data['rank'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->set('translations.url.en', $translations['en']['url'])
            ->set('translations.url.id', $translations['id']['url'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/home_banners');

        $this->assertDatabaseMissing('home_banners', $data);
        $this->assertDatabaseMissing('home_banner_translations', $translations['en']);
        $this->assertDatabaseMissing('home_banner_translations', $translations['id']);
    }
}
