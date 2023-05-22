<?php

namespace App\Http\Livewire\Cms\Buildings;

use App\Models\Admin;
use App\Models\Building;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowBuildingTest extends TestCase
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
     * The Building instance to support any test cases.
     *
     * @var Building
     */
    protected Building $building;

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

        $this->building = Building::factory()->create();
    }

    /** @test */
    public function show_component_is_accessible()
    {
        Livewire::test('cms.buildings.show-building', ['building' => $this->building])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_building_page()
    {
        Livewire::test('cms.buildings.show-building', ['building' => $this->building])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/buildings/'. $this->building->getKey() .'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.buildings.show-building', ['building' => $this->building])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/buildings');
    }
}
