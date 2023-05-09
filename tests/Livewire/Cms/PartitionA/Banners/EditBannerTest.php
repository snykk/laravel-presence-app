<?php

namespace Tests\Livewire\Cms\PartitionA\Banners;

use App\Models\Admin;
use App\Models\Banner;
use App\Models\Promo;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class EditBannerTest extends TestCase
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
     * The Banner instance to support any test cases.
     *
     * @var Banner
     */
    protected Banner $banner;

    /**
     * Setup the test environment.
     *
     * return void
     */
    public function setUp(): void
    {
        parent::setUp();

        Promo::factory()->create();
        $this->seed(['PermissionSeeder', 'RoleSeeder', 'BannerSeeder']);

        $this->admin = Admin::factory()->create()->assignRole('super-administrator');

        $this->actingAs($this->admin, config('cms.guard'));

        $this->banner = Banner::first();
    }

    /** @test */
    public function edit_component_is_accessible()
    {
        Livewire::test('cms.banners.edit-banner', ['banner' => $this->banner])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_update_the_existing_banner_record()
    {
        $data = $this->fakeRawData(Banner::class);
        $translations = $this->fakeTranslationData(Banner::class);

        Livewire::test('cms.banners.edit-banner', ['banner' => $this->banner])
            ->set('banner.rank', $data['rank'])
            ->set('banner.promo_id', $data['promo_id'])
            ->set('translations.standalone_url.en', $translations['en']['standalone_url'])
            ->set('translations.standalone_url.id', $translations['id']['standalone_url'])
            ->set('isMainBanner', ($data['is_main_banner']) ? 'true' : 'false')
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/banners');

        $this->assertDatabaseHas('banners', $data);
        $this->assertDatabaseHas('banner_translations', $translations['en']);
        $this->assertDatabaseHas('banner_translations', $translations['id']);

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The banner has been updated.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_updating_existing_banner_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(Banner::class);
        $translations = $this->fakeTranslationData(Banner::class);

        $this->banner->update(['standalone_url' => [
            'en' => 'url-en',
            'id' => 'url-id',
        ]]);

        Livewire::test('cms.banners.edit-banner', ['banner' => $this->banner])
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
