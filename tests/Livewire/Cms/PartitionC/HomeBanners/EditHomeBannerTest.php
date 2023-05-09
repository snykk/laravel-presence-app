<?php

namespace Tests\Livewire\Cms\PartitionC\HomeBanners;

use App\Models\Admin;
use App\Models\HomeBanner;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class EditHomeBannerTest extends TestCase
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
     * The Home Banner instance to support any test cases.
     *
     * @var HomeBanner
     */
    protected HomeBanner $homeBanner;

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

        $this->homeBanner = HomeBanner::factory()->create();
    }

    /** @test */
    public function edit_component_is_accessible()
    {
        Livewire::test('cms.home-banners.edit-home-banner', ['homeBanner' => $this->homeBanner])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_update_the_existing_home_banner_record()
    {
        $data = $this->fakeRawData(HomeBanner::class);
        $translations = $this->fakeTranslationData(HomeBanner::class);

        Livewire::test('cms.home-banners.edit-home-banner', ['homeBanner' => $this->homeBanner])
            ->set('homeBanner.rank', $data['rank'])
            ->set('homeBanner.rank', $data['rank'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->set('translations.url.en', $translations['en']['url'])
            ->set('translations.url.id', $translations['id']['url'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/home_banners');

        $this->assertDatabaseHas('home_banners', $data);
        $this->assertDatabaseHas('home_banner_translations', $translations['en']);
        $this->assertDatabaseHas('home_banner_translations', $translations['id']);

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The home banner has been updated.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_updating_existing_home_banner_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(HomeBanner::class);
        $translations = $this->fakeTranslationData(HomeBanner::class);

        Livewire::test('cms.home-banners.edit-home-banner', ['homeBanner' => $this->homeBanner])
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
