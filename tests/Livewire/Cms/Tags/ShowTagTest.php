<?php

namespace App\Http\Livewire\Cms\Tags;

use App\Models\Admin;
use App\Models\Tag;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowTagTest extends TestCase
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
     * The Tag instance to support any test cases.
     *
     * @var Tag
     */
    protected Tag $tag;

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

        $this->tag = Tag::factory()->create();
    }

    /** @test */
    public function show_component_is_accessible()
    {
        Livewire::test('cms.tags.show-tag', ['tag' => $this->tag])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_tag_page()
    {
        Livewire::test('cms.tags.show-tag', ['tag' => $this->tag])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/tags/'.$this->tag->getKey().'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.tags.show-tag', ['tag' => $this->tag])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/tags');
    }
}
