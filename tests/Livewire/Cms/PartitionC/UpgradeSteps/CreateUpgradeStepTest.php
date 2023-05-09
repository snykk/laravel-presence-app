<?php

namespace Tests\Livewire\Cms\PartitionC\UpgradeSteps;

use App\Models\Admin;
use App\Models\UpgradeStep;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class CreateUpgradeStepTest extends TestCase
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
        Livewire::test('cms.upgrade-steps.create-upgrade-step')
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_save_the_new_upgrade_step_record()
    {
        $data = $this->fakeRawData(UpgradeStep::class);
        $translations = $this->fakeTranslationData(UpgradeStep::class);

        Livewire::test('cms.upgrade-steps.create-upgrade-step')
            ->set('upgradeStep.order', $data['order'])
            ->set('upgradeStep.order', $data['order'])
            ->set('published', ($data['published_at'] <= Carbon::now()) ? 'true' : 'false')
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/upgrade_steps');

        unset($data['published_at']);
        $this->assertDatabaseHas('upgrade_steps', $data);
        $this->assertDatabaseHas('upgrade_step_translations', $translations['en']);
        $this->assertDatabaseHas('upgrade_step_translations', $translations['id']);

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The new upgrade step has been saved.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_creating_new_upgrade_step_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(UpgradeStep::class);
        $translations = $this->fakeTranslationData(UpgradeStep::class);

        Livewire::test('cms.upgrade-steps.create-upgrade-step')
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
