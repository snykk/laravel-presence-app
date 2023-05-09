<?php

namespace App\Http\Livewire\Cms\UpgradeSteps;

use App\Models\Admin;
use App\Models\UpgradeStep;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowUpgradeStepTest extends TestCase
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
     * The Upgrade Step instance to support any test cases.
     *
     * @var UpgradeStep
     */
    protected UpgradeStep $upgradeStep;

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

        $this->upgradeStep = UpgradeStep::factory()->create();
    }

    /** @test */
    public function show_component_is_accessible()
    {
        Livewire::test('cms.upgrade-steps.show-upgrade-step', ['upgradeStep' => $this->upgradeStep])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_upgrade_step_page()
    {
        Livewire::test('cms.upgrade-steps.show-upgrade-step', ['upgradeStep' => $this->upgradeStep])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/upgrade_steps/'.$this->upgradeStep->getKey().'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.upgrade-steps.show-upgrade-step', ['upgradeStep' => $this->upgradeStep])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/upgrade_steps');
    }
}
