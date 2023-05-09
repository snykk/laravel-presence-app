<?php

namespace App\Http\Livewire\Cms\Departments;

use App\Models\Admin;
use App\Models\Department;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowDepartmentTest extends TestCase
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
    public function show_component_is_accessible()
    {
        Livewire::test('cms.departments.show-department', ['department' => $this->department])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_department_page()
    {
        Livewire::test('cms.departments.show-department', ['department' => $this->department])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/departments/'. $this->department->getKey() .'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.departments.show-department', ['department' => $this->department])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/departments');
    }
}
