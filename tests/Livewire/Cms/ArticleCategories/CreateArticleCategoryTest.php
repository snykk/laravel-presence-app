<?php

namespace Tests\Livewire\Cms\ArticleCategories;

use App\Models\Admin;
use App\Models\ArticleCategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class CreateArticleCategoryTest extends TestCase
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
        Livewire::test('cms.article-categories.create-article-category')
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_save_the_new_article_category_record()
    {
        $data = $this->fakeRawData(ArticleCategory::class);
        // fake translations data

        Livewire::test('cms.article-categories.create-article-category')
            ->set('translations.name.en', $translations['en']['name'])
            ->set('translations.name.id', $translations['id']['name'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/article_categories');

        $this->assertDatabaseHas('article_categories', $data);
        // assert translation data exists

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The new article category has been saved.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_creating_new_article_category_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(ArticleCategory::class);
        // fake translations data

        Livewire::test('cms.article-categories.create-article-category')
            ->set('translations.name.en', $translations['en']['name'])
            ->set('translations.name.id', $translations['id']['name'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/article_categories');

        $this->assertDatabaseMissing('article_categories', $data);
        // assert translation data missing
    }
}
