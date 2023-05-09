<?php

namespace App\Http\Livewire\Cms\Articles;

use App\Models\Admin;
use App\Models\Article;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowArticleTest extends TestCase
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
     * The Article instance to support any test cases.
     *
     * @var Article
     */
    protected Article $article;

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

        $this->article = Article::factory()->create();
    }

    /** @test */
    public function show_component_is_accessible()
    {
        Livewire::test('cms.articles.show-article', ['articleId' => $this->article->id])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_article_page()
    {
        Livewire::test('cms.articles.show-article', ['articleId' => $this->article->id])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/articles/'.$this->article->id.'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.articles.show-article', ['articleId' => $this->article->id])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/articles');
    }
}
