<?php

namespace App\Http\Livewire\Cms\Menus;

use App\Models\Admin;
use App\Models\Menu;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowMenuTest extends TestCase
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
     * The Menu instance to support any test cases.
     *
     * @var Menu
     */
    protected Menu $menu;

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

        $this->menu = Menu::factory()->create();
    }

    /** @test */
    public function show_component_is_accessible()
    {
        Livewire::test('cms.menus.show-menu', ['menu' => $this->menu])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_menu_page()
    {
        Livewire::test('cms.menus.show-menu', ['menu' => $this->menu])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/menus/'.$this->menu->getKey().'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.menus.show-menu', ['menu' => $this->menu])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/menus');
    }
}
