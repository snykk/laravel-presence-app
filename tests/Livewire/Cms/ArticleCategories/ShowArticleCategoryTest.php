<?php

namespace App\Http\Livewire\Cms\ArticleCategories;

use App\Models\Admin;
use App\Models\ArticleCategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowArticleCategoryTest extends TestCase
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
     * The Article Category instance to support any test cases.
     *
     * @var ArticleCategory
     */
    protected ArticleCategory $articleCategory;

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

        $this->articleCategory = ArticleCategory::factory()->create();
    }

    /** @test */
    public function show_component_is_accessible()
    {
        Livewire::test('cms.article-categories.show-article-category', ['articleCategory' => $this->articleCategory])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_article_category_page()
    {
        Livewire::test('cms.article-categories.show-article-category', ['articleCategory' => $this->articleCategory])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/article_categories/'.$this->articleCategory->getKey().'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.article-categories.show-article-category', ['articleCategory' => $this->articleCategory])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/article_categories');
    }
}
