<?php

namespace Tests\Livewire\Cms\Buildings;

use App\Models\Admin;
use App\Models\Building;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class EditBuildingTest extends TestCase
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
    public function edit_component_is_accessible()
    {
        Livewire::test('cms.buildings.edit-building', ['building' => $this->building])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_update_the_existing_building_record()
    {
        $data = $this->fakeRawData(Building::class);
// fake translations data

        Livewire::test('cms.buildings.edit-building', ['building' => $this->building])
            ->set('building.name', $data['name'])
            ->set('building.address', $data['address'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/buildings');

        $this->assertDatabaseHas('buildings', $data);
// assert translation data exists

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The building has been updated.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_updating_existing_building_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(Building::class);
// fake translations data

        Livewire::test('cms.buildings.edit-building', ['building' => $this->building])
            ->set('building.name', $data['name'])
            ->set('building.address', $data['address'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/buildings');

        $this->assertDatabaseMissing('buildings', $data);
// assert translation data missing
    }
}
