<?php

namespace Tests\Livewire\Cms\Subjects;

use App\Http\Livewire\Cms\Subjects\SubjectsIndex;
use App\Models\Admin;
use App\Models\Subject;
use Illuminate\Foundation\Testing\Concerns\InteractsWithSession;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class SubjectsIndexTest extends TestCase
{
    use CmsTests;
    use DatabaseMigrations;
    use InteractsWithSession;

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

        $this->session([]);

        $this->seed(['PermissionSeeder', 'RoleSeeder']);

        $this->admin = Admin::factory()->create()->assignRole('super-administrator');

        $this->actingAs($this->admin, config('cms.guard'));

        Subject::factory(3)->create();
    }

    /** @test */
    public function datatable_component_is_accessible()
    {
        Livewire::test('cms.subjects.subjects-index')
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_jump_to_a_specific_page()
    {
        Livewire::test('cms.subjects.subjects-index')
            ->set('perPage', 1)
            ->call('refresh')
            ->call('goTo', 2)
            ->assertSet('currentPage', 2);
    }

    /** @test */
    public function it_can_load_its_state_from_the_session_store()
    {
        $data = [
            'perPage' => 1,
            'sortColumn' => 'created_at',
            'sortDirection' => 'desc'
        ];
        session()->put(SubjectsIndex::class, $data);

        Livewire::test('cms.subjects.subjects-index')
            ->assertSet('perPage', 1)
            ->assertSet('sortColumn', 'created_at')
            ->assertSet('sortDirection', 'desc');
    }
}
