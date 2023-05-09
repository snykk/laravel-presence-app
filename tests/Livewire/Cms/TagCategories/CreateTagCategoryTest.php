<?php

namespace Tests\Livewire\Cms\TagCategories;

use App\Models\Admin;
use App\Models\TagCategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class CreateTagCategoryTest extends TestCase
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
        Livewire::test('cms.tag-categories.create-tag-category')
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_save_the_new_tag_category_record()
    {
        $data = $this->fakeRawData(TagCategory::class);
        // fake translations data

        Livewire::test('cms.tag-categories.create-tag-category')
            ->set('tagCategory.name', $data['name'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/tag_categories');

        $this->assertDatabaseHas('tag_categories', $data);
        // assert translation data exists

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The new tag category has been saved.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_creating_new_tag_category_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(TagCategory::class);
        // fake translations data

        Livewire::test('cms.tag-categories.create-tag-category')
            ->set('tagCategory.name', $data['name'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/tag_categories');

        $this->assertDatabaseMissing('tag_categories', $data);
        // assert translation data missing
    }
}
