<?php

namespace Tests\Livewire\Cms\Subjects;

use App\Models\Admin;
use App\Models\Subject;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class EditSubjectTest extends TestCase
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
    public function edit_component_is_accessible()
    {
        Livewire::test('cms.subjects.edit-subject', ['subject' => $this->subject])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_update_the_existing_subject_record()
    {
        $data = $this->fakeRawData(Subject::class);
// fake translations data

        Livewire::test('cms.subjects.edit-subject', ['subject' => $this->subject])
            ->set('subject.department_id', $data['department_id'])
            ->set('subject.code', $data['code'])
            ->set('subject.score_credit', $data['score_credit'])
            ->set('subject.department_id', $data['department_id'])
            ->set('subject.code', $data['code'])
            ->set('subject.score_credit', $data['score_credit'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/subjects');

        $this->assertDatabaseHas('subjects', $data);
// assert translation data exists

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The subject has been updated.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_updating_existing_subject_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(Subject::class);
// fake translations data

        Livewire::test('cms.subjects.edit-subject', ['subject' => $this->subject])
            ->set('subject.department_id', $data['department_id'])
            ->set('subject.code', $data['code'])
            ->set('subject.score_credit', $data['score_credit'])
            ->set('subject.department_id', $data['department_id'])
            ->set('subject.code', $data['code'])
            ->set('subject.score_credit', $data['score_credit'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/subjects');

        $this->assertDatabaseMissing('subjects', $data);
// assert translation data missing
    }
}
