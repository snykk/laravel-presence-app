<?php

namespace Tests\Livewire\Cms\Faqs;

use App\Models\Admin;
use App\Models\Faq;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class EditFaqTest extends TestCase
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
     * The Faq instance to support any test cases.
     *
     * @var Faq
     */
    protected Faq $faq;

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

        $this->faq = Faq::factory()->create();
    }

    /** @test */
    public function edit_component_is_accessible()
    {
        Livewire::test('cms.faqs.edit-faq', ['faq' => $this->faq])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_update_the_existing_faq_record()
    {
        $data = $this->fakeRawData(Faq::class);
        $translations = $this->fakeTranslationData(Faq::class);

        Livewire::test('cms.faqs.edit-faq', ['faq' => $this->faq])
            ->set('faq.order', $data['order'])
            ->set('faq.slug', $data['slug'])
            ->set('faq.published_at', $data['published_at'])
            ->set('faq.order', $data['order'])
            ->set('faq.slug', $data['slug'])
            ->set('faq.published_at', $data['published_at'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->set('translations.content.en', $translations['en']['content'])
            ->set('translations.content.id', $translations['id']['content'])
            ->set('translations.cta_text.en', $translations['en']['cta_text'])
            ->set('translations.cta_text.id', $translations['id']['cta_text'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/faqs');

        $this->assertDatabaseHas('faqs', $data);
        $this->assertDatabaseHas('faq_translations', $translations['en']);
        $this->assertDatabaseHas('faq_translations', $translations['id']);

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The faq has been updated.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_updating_existing_faq_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(Faq::class);
        $translations = $this->fakeTranslationData(Faq::class);

        Livewire::test('cms.faqs.edit-faq', ['faq' => $this->faq])
            ->set('faq.order', $data['order'])
            ->set('faq.slug', $data['slug'])
            ->set('faq.published_at', $data['published_at'])
            ->set('faq.order', $data['order'])
            ->set('faq.slug', $data['slug'])
            ->set('faq.published_at', $data['published_at'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->set('translations.content.en', $translations['en']['content'])
            ->set('translations.content.id', $translations['id']['content'])
            ->set('translations.cta_text.en', $translations['en']['cta_text'])
            ->set('translations.cta_text.id', $translations['id']['cta_text'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/faqs');

        $this->assertDatabaseMissing('faqs', $data);
        $this->assertDatabaseMissing('faq_translations', $translations['en']);
        $this->assertDatabaseMissing('faq_translations', $translations['id']);
    }
}
