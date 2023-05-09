<?php

namespace Tests\Livewire\Cms\TagCategories;

use App\Models\Admin;
use App\Models\TagCategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class EditTagCategoryTest extends TestCase
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
    public function edit_component_is_accessible()
    {
        Livewire::test('cms.tag-categories.edit-tag-category', ['tagCategory' => $this->tagCategory])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_update_the_existing_tag_category_record()
    {
        $data = $this->fakeRawData(TagCategory::class);
        // fake translations data

        Livewire::test('cms.tag-categories.edit-tag-category', ['tagCategory' => $this->tagCategory])
            ->set('tagCategory.name', $data['name'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/tag_categories');

        $this->assertDatabaseHas('tag_categories', $data);
        // assert translation data exists

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The tag category has been updated.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_updating_existing_tag_category_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(TagCategory::class);
        // fake translations data

        Livewire::test('cms.tag-categories.edit-tag-category', ['tagCategory' => $this->tagCategory])
            ->set('tagCategory.name', $data['name'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/tag_categories');

        $this->assertDatabaseMissing('tag_categories', $data);
        // assert translation data missing
    }
}
