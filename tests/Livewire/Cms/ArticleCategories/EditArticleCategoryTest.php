<?php

namespace Tests\Livewire\Cms\ArticleCategories;

use App\Models\Admin;
use App\Models\ArticleCategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class EditArticleCategoryTest extends TestCase
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
    public function edit_component_is_accessible()
    {
        Livewire::test('cms.article-categories.edit-article-category', ['articleCategory' => $this->articleCategory])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_update_the_existing_article_category_record()
    {
        $data = $this->fakeRawData(ArticleCategory::class);
        // fake translations data

        Livewire::test('cms.article-categories.edit-article-category', ['articleCategory' => $this->articleCategory])
            ->set('translations.name.en', $translations['en']['name'])
            ->set('translations.name.id', $translations['id']['name'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/article_categories');

        $this->assertDatabaseHas('article_categories', $data);
        // assert translation data exists

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The article category has been updated.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_updating_existing_article_category_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(ArticleCategory::class);
        // fake translations data

        Livewire::test('cms.article-categories.edit-article-category', ['articleCategory' => $this->articleCategory])
            ->set('translations.name.en', $translations['en']['name'])
            ->set('translations.name.id', $translations['id']['name'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/article_categories');

        $this->assertDatabaseMissing('article_categories', $data);
        // assert translation data missing
    }
}
