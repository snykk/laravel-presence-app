<?php

namespace App\Http\Livewire\Cms\Locations;

use App\Models\Admin;
use App\Models\Location;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowLocationTest extends TestCase
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
     * The Location instance to support any test cases.
     *
     * @var Location
     */
    protected Location $location;

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

        $this->location = Location::factory()->create();
    }

    /** @test */
    public function show_component_is_accessible()
    {
        Livewire::test('cms.locations.show-location', ['location' => $this->location])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_location_page()
    {
        Livewire::test('cms.locations.show-location', ['location' => $this->location])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/locations/'.$this->location->getKey().'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.locations.show-location', ['location' => $this->location])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/locations');
    }
}
