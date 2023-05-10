<?php

namespace Tests\Livewire\Cms\Schedules;

use App\Models\Admin;
use App\Models\Schedule;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class CreateScheduleTest extends TestCase
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
        Livewire::test('cms.schedules.create-schedule')
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_save_the_new_schedule_record()
    {
        $data = $this->fakeRawData(Schedule::class);
// fake translations data

        Livewire::test('cms.schedules.create-schedule')
            ->set('schedule.seq', $data['seq'])
            ->set('schedule.start_time', $data['start_time'])
            ->set('schedule.end_time', $data['end_time'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/schedules');

        $this->assertDatabaseHas('schedules', $data);
// assert translation data exists

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The new schedule has been saved.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_creating_new_schedule_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(Schedule::class);
// fake translations data

        Livewire::test('cms.schedules.create-schedule')
            ->set('schedule.seq', $data['seq'])
            ->set('schedule.start_time', $data['start_time'])
            ->set('schedule.end_time', $data['end_time'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/schedules');

        $this->assertDatabaseMissing('schedules', $data);
// assert translation data missing
    }
}
