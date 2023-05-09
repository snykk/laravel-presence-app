<?php

namespace Tests\Livewire\Cms\PartitionC\Locations;

use App\Models\Admin;
use App\Models\Location;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class EditLocationTest extends TestCase
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
    public function edit_component_is_accessible()
    {
        Livewire::test('cms.locations.edit-location', ['location' => $this->location])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_update_the_existing_location_record()
    {
        $data = Location::factory()->raw();

        Livewire::test('cms.locations.edit-location', ['location' => $this->location])
            ->set('location.title', $data['title'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/locations');

        $this->assertDatabaseHas('locations', $data);

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The location has been updated.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_updating_existing_location_and_go_back_to_index_page()
    {
        $data = Location::factory()->raw();

        Livewire::test('cms.locations.edit-location', ['location' => $this->location])
            ->set('location.title', $data['title'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/locations');

        $this->assertDatabaseMissing('locations', $data);
    }
}
