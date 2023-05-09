<?php

namespace Tests\Livewire\Cms\PartitionC\UpgradeSteps;

use App\Models\Admin;
use App\Models\UpgradeStep;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class EditUpgradeStepTest extends TestCase
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
    public function edit_component_is_accessible()
    {
        Livewire::test('cms.upgrade-steps.edit-upgrade-step', ['upgradeStep' => $this->upgradeStep])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_update_the_existing_upgrade_step_record()
    {
        $data = $this->fakeRawData(UpgradeStep::class);
        $translations = $this->fakeTranslationData(UpgradeStep::class);

        Livewire::test('cms.upgrade-steps.edit-upgrade-step', ['upgradeStep' => $this->upgradeStep])
            ->set('upgradeStep.order', $data['order'])
            ->set('upgradeStep.order', $data['order'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/upgrade_steps');

        $this->assertDatabaseHas('upgrade_steps', $data);
        $this->assertDatabaseHas('upgrade_step_translations', $translations['en']);
        $this->assertDatabaseHas('upgrade_step_translations', $translations['id']);

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The upgrade step has been updated.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_updating_existing_upgrade_step_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(UpgradeStep::class);
        $translations = $this->fakeTranslationData(UpgradeStep::class);

        Livewire::test('cms.upgrade-steps.edit-upgrade-step', ['upgradeStep' => $this->upgradeStep])
            ->set('upgradeStep.order', $data['order'])
            ->set('upgradeStep.order', $data['order'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/upgrade_steps');

        $this->assertDatabaseMissing('upgrade_steps', $data);
        $this->assertDatabaseMissing('upgrade_step_translations', $translations['en']);
        $this->assertDatabaseMissing('upgrade_step_translations', $translations['id']);
    }
}
