<?php

namespace App\Http\Livewire\Cms\Ctas;

use App\Models\Admin;
use App\Models\Cta;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowCtaTest extends TestCase
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
     * The Cta instance to support any test cases.
     *
     * @var Cta
     */
    protected Cta $cta;

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

        $this->cta = Cta::factory()->create();
    }

    /** @test */
    public function show_component_is_accessible()
    {
        Livewire::test('cms.ctas.show-cta', ['cta' => $this->cta])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_cta_page()
    {
        Livewire::test('cms.ctas.show-cta', ['cta' => $this->cta])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/ctas/'.$this->cta->getRouteKey().'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.ctas.show-cta', ['cta' => $this->cta])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/ctas');
    }
}
