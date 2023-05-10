<?php

namespace Tests\Livewire\Cms\Subjects;

use App\Models\Admin;
use App\Models\Subject;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class CreateSubjectTest extends TestCase
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
        Livewire::test('cms.subjects.create-subject')
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_save_the_new_subject_record()
    {
        $data = $this->fakeRawData(Subject::class);
// fake translations data

        Livewire::test('cms.subjects.create-subject')
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
        self::assertEquals('The new subject has been saved.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_creating_new_subject_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(Subject::class);
// fake translations data

        Livewire::test('cms.subjects.create-subject')
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
