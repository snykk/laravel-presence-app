<?php

namespace Tests\Livewire\Cms\Classrooms;

use App\Models\Admin;
use App\Models\Classroom;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class CreateClassroomTest extends TestCase
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
        Livewire::test('cms.classrooms.create-classroom')
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_save_the_new_classroom_record()
    {
        $data = $this->fakeRawData(Classroom::class);
// fake translations data

        Livewire::test('cms.classrooms.create-classroom')
            ->set('classroom.building_id', $data['building_id'])
            ->set('classroom.room_number', $data['room_number'])
            ->set('classroom.capacity', $data['capacity'])
            ->set('classroom.floor', $data['floor'])
            ->set('classroom.status', $data['status'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/classrooms');

        $this->assertDatabaseHas('classrooms', $data);
// assert translation data exists

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The new classroom has been saved.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_creating_new_classroom_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(Classroom::class);
// fake translations data

        Livewire::test('cms.classrooms.create-classroom')
            ->set('classroom.building_id', $data['building_id'])
            ->set('classroom.room_number', $data['room_number'])
            ->set('classroom.capacity', $data['capacity'])
            ->set('classroom.floor', $data['floor'])
            ->set('classroom.status', $data['status'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/classrooms');

        $this->assertDatabaseMissing('classrooms', $data);
// assert translation data missing
    }
}
