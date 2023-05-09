<?php

namespace App\Http\Livewire\Cms\Banners;

use App\Models\Admin;
use App\Models\Banner;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowBannerTest extends TestCase
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

        $this->seed(['PermissionSeeder', 'RoleSeeder']);

        $this->admin = Admin::factory()->create()->assignRole('super-administrator');

        $this->actingAs($this->admin, config('cms.guard'));

        $this->banner = Banner::factory()->create();
    }

    /** @test */
    public function show_component_is_accessible()
    {
        Livewire::test('cms.banners.show-banner', ['banner' => $this->banner])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_banner_page()
    {
        Livewire::test('cms.banners.show-banner', ['banner' => $this->banner])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/banners/'.$this->banner->getKey().'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.banners.show-banner', ['banner' => $this->banner])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/banners');
    }
}
