<?php

namespace Tests\Livewire\Cms\PartitionC\Locations;

use App\Models\Admin;
use App\Models\Location;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class CreateLocationTest extends TestCase
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
        Livewire::test('cms.locations.create-location')
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_save_the_new_location_record()
    {
        $data = Location::factory()->raw();

        Livewire::test('cms.locations.create-location')
            ->set('location.title', $data['title'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/locations');

        unset($data['name']);
        $this->assertDatabaseHas('locations', $data);

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The new location has been saved.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_creating_new_location_and_go_back_to_index_page()
    {
        $data = Location::factory()->raw();

        Livewire::test('cms.locations.create-location')
            ->set('location.title', $data['title'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/locations');

        unset($data['name']);
        $this->assertDatabaseMissing('locations', $data);
    }
}
