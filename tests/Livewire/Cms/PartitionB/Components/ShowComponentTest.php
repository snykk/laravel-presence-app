<?php

namespace App\Http\Livewire\Cms\Components;

use App\Models\Admin;
use App\Models\Component;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowComponentTest extends TestCase
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
     * The Component instance to support any test cases.
     *
     * @var Component
     */
    protected Component $component;

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

        $this->component = Component::factory()->create();
    }

    /** @test */
    public function show_component_is_accessible()
    {
        Livewire::test('cms.components.show-component', ['componentId' => $this->component->id])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_component_page()
    {
        Livewire::test('cms.components.show-component', ['componentId' => $this->component->id])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/components/'.$this->component->id.'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.components.show-component', ['componentId' => $this->component->id])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/components');
    }
}
