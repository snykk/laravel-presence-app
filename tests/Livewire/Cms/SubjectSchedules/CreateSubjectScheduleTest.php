<?php

namespace Tests\Livewire\Cms\SubjectSchedules;

use App\Models\Admin;
use App\Models\SubjectSchedule;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class CreateSubjectScheduleTest extends TestCase
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
        Livewire::test('cms.subject-schedules.create-subject-schedule')
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_save_the_new_subject_schedule_record()
    {
        $data = $this->fakeRawData(SubjectSchedule::class);
// fake translations data

        Livewire::test('cms.subject-schedules.create-subject-schedule')
            ->set('subjectSchedule.subject_id', $data['subject_id'])
            ->set('subjectSchedule.schedule_id', $data['schedule_id'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/subject_schedules');

        $this->assertDatabaseHas('subject_schedules', $data);
// assert translation data exists

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The new subject schedule has been saved.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_creating_new_subject_schedule_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(SubjectSchedule::class);
// fake translations data

        Livewire::test('cms.subject-schedules.create-subject-schedule')
            ->set('subjectSchedule.subject_id', $data['subject_id'])
            ->set('subjectSchedule.schedule_id', $data['schedule_id'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/subject_schedules');

        $this->assertDatabaseMissing('subject_schedules', $data);
// assert translation data missing
    }
}
