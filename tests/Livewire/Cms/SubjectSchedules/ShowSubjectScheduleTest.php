<?php

namespace App\Http\Livewire\Cms\SubjectSchedules;

use App\Models\Admin;
use App\Models\SubjectSchedule;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowSubjectScheduleTest extends TestCase
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
    public function show_component_is_accessible()
    {
        Livewire::test('cms.subject-schedules.show-subject-schedule', ['subjectSchedule' => $this->subjectSchedule])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_subject_schedule_page()
    {
        Livewire::test('cms.subject-schedules.show-subject-schedule', ['subjectSchedule' => $this->subjectSchedule])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/subject_schedules/'. $this->subjectSchedule->getKey() .'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.subject-schedules.show-subject-schedule', ['subjectSchedule' => $this->subjectSchedule])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/subject_schedules');
    }
}
