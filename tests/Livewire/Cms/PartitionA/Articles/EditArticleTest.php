<?php

namespace Tests\Livewire\Cms\PartitionA\Articles;

use App\Models\Admin;
use App\Models\Article;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class EditArticleTest extends TestCase
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
    public function edit_component_is_accessible()
    {
        Livewire::test('cms.articles.edit-article', ['articleId' => $this->article->id])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_update_the_existing_article_record()
    {
        $data = $this->fakeRawData(Article::class, [
            'published_at' => date('Y-m-d H:i:s'),
        ]);
        if ($data['published_at'] == null) {
            $data['published_at'] = now()->format('Y-m-d H:i:s');
        }
        $translations = $this->fakeTranslationData(Article::class);
        $seoMetas = $this->fakeAttachedSeoMetaData(Article::class);

        $test = Livewire::test('cms.articles.create-article', ['articleId' => $this->article->id])
                    ->set('article.author', $data['author'])
                    ->set('article.highlighted', $data['highlighted'])
                    ->set('publishedAt', $data['published_at']);

        foreach ($seoMetas as $locale => $seoMeta) {
            $test = $test
                ->set('translations.slug.'.$locale, $translations[$locale]['slug'])
                ->set('translations.title.'.$locale, $translations[$locale]['title'])
                ->set('translations.description.'.$locale, $translations[$locale]['description'])
                ->set('content.'.$locale, $translations[$locale]['content'])
                ->set('seoMeta.seo_title.'.$locale, $seoMeta['seo_title'])
                ->set('seoMeta.seo_description.'.$locale, $seoMeta['seo_description'])
                ->set('seoMeta.open_graph_type.'.$locale, $seoMeta['open_graph_type']);
        }

        $test->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/articles');

        $this->assertDatabaseHas('articles', $data);
        foreach ($seoMetas as $locale => $seoMeta) {
            unset($translations[$locale]['slug']);
            unset($translations[$locale]['read_time']);
            unset($translations[$locale]['description']);
            unset($translations[$locale]['title']);
            unset($translations[$locale]['content']);
            $this->assertDatabaseHas('article_translations', $translations[$locale]);

            unset($seoMeta['seo_url']);
            unset($seoMeta['seo_content']);
            $this->assertDatabaseHas('seo_metas', $seoMeta);
        }

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The new article has been saved.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_updating_existing_article_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(Article::class, [
            'published_at' => date('Y-m-d H:i:s'),
        ]);
        if ($data['published_at'] == null) {
            $data['published_at'] = now()->format('Y-m-d H:i:s');
        }
        $translations = $this->fakeTranslationData(Article::class);

        Livewire::test('cms.articles.edit-article', ['articleId' => $this->article->id])
            ->set('article.author', $data['author'])
            ->set('article.highlighted', $data['highlighted'])
            ->set('publishedAt', $data['published_at'])
            ->set('translations.slug.en', $translations['en']['slug'])
            ->set('translations.slug.id', $translations['id']['slug'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->set('translations.description.en', $translations['en']['description'])
            ->set('translations.description.id', $translations['id']['description'])
            ->set('content.en', $translations['en']['content'])
            ->set('content.id', $translations['id']['content'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/articles');

        $this->assertDatabaseMissing('articles', $data);
        $this->assertDatabaseMissing('article_translations', $translations['en']);
        $this->assertDatabaseMissing('article_translations', $translations['id']);
    }
}
