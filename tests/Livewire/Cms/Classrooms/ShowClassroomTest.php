<?php

namespace App\Http\Livewire\Cms\Classrooms;

use App\Models\Admin;
use App\Models\Classroom;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowClassroomTest extends TestCase
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
     * The Classroom instance to support any test cases.
     *
     * @var Classroom
     */
    protected Classroom $classroom;

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

        $this->classroom = Classroom::factory()->create();
    }

    /** @test */
    public function show_component_is_accessible()
    {
        Livewire::test('cms.classrooms.show-classroom', ['classroom' => $this->classroom])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_classroom_page()
    {
        Livewire::test('cms.classrooms.show-classroom', ['classroom' => $this->classroom])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/classrooms/'. $this->classroom->getKey() .'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.classrooms.show-classroom', ['classroom' => $this->classroom])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/classrooms');
    }
}
