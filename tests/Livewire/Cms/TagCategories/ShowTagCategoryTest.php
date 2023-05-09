<?php

namespace App\Http\Livewire\Cms\TagCategories;

use App\Models\Admin;
use App\Models\TagCategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowTagCategoryTest extends TestCase
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
     * The Tag Category instance to support any test cases.
     *
     * @var TagCategory
     */
    protected TagCategory $tagCategory;

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

        $this->tagCategory = TagCategory::factory()->create();
    }

    /** @test */
    public function show_component_is_accessible()
    {
        Livewire::test('cms.tag-categories.show-tag-category', ['tagCategory' => $this->tagCategory])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_tag_category_page()
    {
        Livewire::test('cms.tag-categories.show-tag-category', ['tagCategory' => $this->tagCategory])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/tag_categories/'.$this->tagCategory->getKey().'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.tag-categories.show-tag-category', ['tagCategory' => $this->tagCategory])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/tag_categories');
    }
}
