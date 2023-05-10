<?php

namespace Tests\Livewire\Cms\SubjectSchedules;

use App\Models\Admin;
use App\Models\SubjectSchedule;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class EditSubjectScheduleTest extends TestCase
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
     * The Subject Schedule instance to support any test cases.
     *
     * @var SubjectSchedule
     */
    protected SubjectSchedule $subjectSchedule;

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

        $this->subjectSchedule = SubjectSchedule::factory()->create();
    }

    /** @test */
    public function edit_component_is_accessible()
    {
        Livewire::test('cms.subject-schedules.edit-subject-schedule', ['subjectSchedule' => $this->subjectSchedule])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_update_the_existing_subject_schedule_record()
    {
        $data = $this->fakeRawData(SubjectSchedule::class);
// fake translations data

        Livewire::test('cms.subject-schedules.edit-subject-schedule', ['subjectSchedule' => $this->subjectSchedule])
            ->set('subjectSchedule.subject_id', $data['subject_id'])
            ->set('subjectSchedule.schedule_id', $data['schedule_id'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/subject_schedules');

        $this->assertDatabaseHas('subject_schedules', $data);
// assert translation data exists

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The subject schedule has been updated.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_updating_existing_subject_schedule_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(SubjectSchedule::class);
// fake translations data

        Livewire::test('cms.subject-schedules.edit-subject-schedule', ['subjectSchedule' => $this->subjectSchedule])
            ->set('subjectSchedule.subject_id', $data['subject_id'])
            ->set('subjectSchedule.schedule_id', $data['schedule_id'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/subject_schedules');

        $this->assertDatabaseMissing('subject_schedules', $data);
// assert translation data missing
    }
}
