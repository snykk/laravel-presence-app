<?php

namespace App\Http\Livewire\Cms\Promos;

use App\Models\Admin;
use App\Models\Promo;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowPromoTest extends TestCase
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
     * The Promo instance to support any test cases.
     *
     * @var Promo
     */
    protected Promo $promo;

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

        $this->promo = Promo::factory()->create();
    }

    /** @test */
    public function show_component_is_accessible()
    {
        Livewire::test('cms.promos.show-promo', ['promoId' => $this->promo->id])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_promo_page()
    {
        Livewire::test('cms.promos.show-promo', ['promoId' => $this->promo->id])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/promos/'.$this->promo->getKey().'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.promos.show-promo', ['promoId' => $this->promo->id])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/promos');
    }
}
