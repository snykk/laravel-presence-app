<?php

namespace Tests\Livewire\Cms\Departments;

use App\Models\Admin;
use App\Models\Department;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class EditDepartmentTest extends TestCase
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
     * The Department instance to support any test cases.
     *
     * @var Department
     */
    protected Department $department;

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

        $this->department = Department::factory()->create();
    }

    /** @test */
    public function edit_component_is_accessible()
    {
        Livewire::test('cms.departments.edit-department', ['department' => $this->department])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_update_the_existing_department_record()
    {
        $data = $this->fakeRawData(Department::class);
// fake translations data

        Livewire::test('cms.departments.edit-department', ['department' => $this->department])
            ->set('department.code', $data['code'])
            ->set('department.code', $data['code'])
            ->set('translations.name.en', $translations['en']['name'])
            ->set('translations.name.id', $translations['id']['name'])
            ->set('translations.description.en', $translations['en']['description'])
            ->set('translations.description.id', $translations['id']['description'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/departments');

        $this->assertDatabaseHas('departments', $data);
// assert translation data exists

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The department has been updated.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_updating_existing_department_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(Department::class);
// fake translations data

        Livewire::test('cms.departments.edit-department', ['department' => $this->department])
            ->set('department.code', $data['code'])
            ->set('department.code', $data['code'])
            ->set('translations.name.en', $translations['en']['name'])
            ->set('translations.name.id', $translations['id']['name'])
            ->set('translations.description.en', $translations['en']['description'])
            ->set('translations.description.id', $translations['id']['description'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/departments');

        $this->assertDatabaseMissing('departments', $data);
// assert translation data missing
    }
}
