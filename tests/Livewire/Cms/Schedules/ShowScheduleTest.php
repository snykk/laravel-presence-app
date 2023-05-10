<?php

namespace App\Http\Livewire\Cms\Schedules;

use App\Models\Admin;
use App\Models\Schedule;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowScheduleTest extends TestCase
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
     * The Schedule instance to support any test cases.
     *
     * @var Schedule
     */
    protected Schedule $schedule;

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

        $this->schedule = Schedule::factory()->create();
    }

    /** @test */
    public function show_component_is_accessible()
    {
        Livewire::test('cms.schedules.show-schedule', ['schedule' => $this->schedule])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_schedule_page()
    {
        Livewire::test('cms.schedules.show-schedule', ['schedule' => $this->schedule])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/schedules/'. $this->schedule->getKey() .'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.schedules.show-schedule', ['schedule' => $this->schedule])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/schedules');
    }
}
