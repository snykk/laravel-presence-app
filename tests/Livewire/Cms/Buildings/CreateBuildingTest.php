<?php

namespace Tests\Livewire\Cms\Buildings;

use App\Models\Admin;
use App\Models\Building;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class CreateBuildingTest extends TestCase
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
        Livewire::test('cms.buildings.create-building')
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_save_the_new_building_record()
    {
        $data = $this->fakeRawData(Building::class);
// fake translations data

        Livewire::test('cms.buildings.create-building')
            ->set('building.name', $data['name'])
            ->set('building.address', $data['address'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/buildings');

        $this->assertDatabaseHas('buildings', $data);
// assert translation data exists

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The new building has been saved.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_creating_new_building_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(Building::class);
// fake translations data

        Livewire::test('cms.buildings.create-building')
            ->set('building.name', $data['name'])
            ->set('building.address', $data['address'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/buildings');

        $this->assertDatabaseMissing('buildings', $data);
// assert translation data missing
    }
}
