<?php

namespace App\Http\Livewire\Cms\TopupMethods;

use App\Models\Admin;
use App\Models\TopupMethod;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowTopupMethodTest extends TestCase
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
     * The Topup Method instance to support any test cases.
     *
     * @var TopupMethod
     */
    protected TopupMethod $topupMethod;

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

        $this->topupMethod = TopupMethod::factory()->create();
    }

    /** @test */
    public function show_component_is_accessible()
    {
        Livewire::test('cms.topup-methods.show-topup-method', ['topupMethod' => $this->topupMethod])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_topup_method_page()
    {
        Livewire::test('cms.topup-methods.show-topup-method', ['topupMethod' => $this->topupMethod])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/topup_methods/'.$this->topupMethod->getKey().'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.topup-methods.show-topup-method', ['topupMethod' => $this->topupMethod])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/topup_methods');
    }
}
