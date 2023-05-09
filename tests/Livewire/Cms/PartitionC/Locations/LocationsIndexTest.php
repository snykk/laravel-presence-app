<?php

namespace Tests\Livewire\Cms\PartitionC\Locations;

use App\Http\Livewire\Cms\Locations\LocationsIndex;
use App\Models\Admin;
use App\Models\Location;
use App\Models\Promo;
use Illuminate\Foundation\Testing\Concerns\InteractsWithSession;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class LocationsIndexTest extends TestCase
{
    use CmsTests;
    use DatabaseMigrations;
    use InteractsWithSession;

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

        $this->session([]);

        $this->seed(['PermissionSeeder', 'RoleSeeder']);

        $this->admin = Admin::factory()->create()->assignRole('super-administrator');

        $this->actingAs($this->admin, config('cms.guard'));

        Location::factory(3)->create();
    }

    /** @test */
    public function datatable_component_is_accessible()
    {
        Livewire::test('cms.locations.locations-index')
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_jump_to_a_specific_page()
    {
        Livewire::test('cms.locations.locations-index')
            ->set('perPage', 1)
            ->call('refresh')
            ->call('goTo', 2)
            ->assertSet('currentPage', 2);
    }

    /** @test */
    public function it_can_load_its_state_from_the_session_store()
    {
        $data = [
            'perPage'       => 1,
            'sortColumn'    => 'created_at',
            'sortDirection' => 'desc',
        ];
        session()->put(LocationsIndex::class, $data);

        Livewire::test('cms.locations.locations-index')
            ->assertSet('perPage', 1)
            ->assertSet('sortColumn', 'created_at')
            ->assertSet('sortDirection', 'desc');
    }

    /** @test */
    public function it_can_set_default_location_for_promo_on_location_deletion()
    {
        $promo = Promo::factory()->create();
        $promo->locations()->attach(1);

        Livewire::test('cms.locations.locations-index')
            ->call('cascadeLocation', 1);

        $this->assertDatabaseHas('promos', [
            'id'            => $promo->id,
            'deleted_at'    => null,
        ]);
        $this->assertTrue(Location::all()->count() === 3);
        $this->assertDatabaseHas('locations', [
            'title'         => Location::DEFAULT_TITLE,
            'deleted_at'    => null,
        ]);
        $this->assertDatabaseHas('location_promo', [
            'location_id' => 4,
            'promo_id'    => $promo->id,
        ]);
    }

    /** @test */
    public function it_only_set_default_location_for_promo_on_location_deletion_when_promo_only_has_one_location()
    {
        $promo = Promo::factory()->create();
        $promo->locations()->attach([1, 2]);

        Livewire::test('cms.locations.locations-index')
            ->call('cascadeLocation', 1);

        $this->assertDatabaseHas('promos', [
            'id'            => $promo->id,
            'deleted_at'    => null,
        ]);
        $this->assertTrue(Location::all()->count() === 3);
        $this->assertDatabaseHas('locations', [
            'title'         => Location::DEFAULT_TITLE,
            'deleted_at'    => null,
        ]);
        $this->assertDatabaseMissing('location_promo', [
            'location_id' => 4,
            'promo_id'    => $promo->id,
        ]);
    }

    /** @test */
    public function it_can_set_default_location_for_promo_on_selected_locations_deletion()
    {
        $promos = Promo::factory(2)->create();
        $promos[0]->locations()->attach(1);
        $promos[1]->locations()->attach([1, 2, 3]);

        Livewire::test('cms.locations.locations-index')
            ->set('selectedRows.1', true)
            ->set('selectedRows.2', true)
            ->call('cascadeSelectedLocation');

        $this->assertDatabaseCount('promos', 2);
        $this->assertTrue(Location::all()->count() === 2);
        $this->assertDatabaseHas('locations', [
            'title'         => Location::DEFAULT_TITLE,
            'deleted_at'    => null,
        ]);
        $this->assertDatabaseHas('location_promo', [
            'location_id' => 4,
            'promo_id'    => $promos[0]->id,
        ]);
        $this->assertDatabaseMissing('location_promo', [
            'location_id' => 4,
            'promo_id'    => $promos[1]->id,
        ]);
    }
}
