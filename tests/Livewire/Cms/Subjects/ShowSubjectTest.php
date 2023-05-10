<?php

namespace App\Http\Livewire\Cms\Subjects;

use App\Models\Admin;
use App\Models\Subject;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowSubjectTest extends TestCase
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
     * The Subject instance to support any test cases.
     *
     * @var Subject
     */
    protected Subject $subject;

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

        $this->subject = Subject::factory()->create();
    }

    /** @test */
    public function show_component_is_accessible()
    {
        Livewire::test('cms.subjects.show-subject', ['subject' => $this->subject])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_subject_page()
    {
        Livewire::test('cms.subjects.show-subject', ['subject' => $this->subject])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/subjects/'. $this->subject->getKey() .'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.subjects.show-subject', ['subject' => $this->subject])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/subjects');
    }
}
