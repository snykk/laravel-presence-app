<?php

namespace App\Http\Livewire\Cms\HomeBanners;

use App\Models\Admin;
use App\Models\HomeBanner;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowHomeBannerTest extends TestCase
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
    public function show_component_is_accessible()
    {
        Livewire::test('cms.home-banners.show-home-banner', ['homeBanner' => $this->homeBanner])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_home_banner_page()
    {
        Livewire::test('cms.home-banners.show-home-banner', ['homeBanner' => $this->homeBanner])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/home_banners/'.$this->homeBanner->getKey().'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.home-banners.show-home-banner', ['homeBanner' => $this->homeBanner])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/home_banners');
    }
}
