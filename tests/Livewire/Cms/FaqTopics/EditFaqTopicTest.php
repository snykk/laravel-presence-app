<?php

namespace Tests\Livewire\Cms\FaqTopics;

use App\Models\Admin;
use App\Models\FaqTopic;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class EditFaqTopicTest extends TestCase
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
     * The Faq Topic instance to support any test cases.
     *
     * @var FaqTopic
     */
    protected FaqTopic $faqTopic;

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

        $this->faqTopic = FaqTopic::factory()->create();
    }

    /** @test */
    public function edit_component_is_accessible()
    {
        Livewire::test('cms.faq-topics.edit-faq-topic', ['faqTopic' => $this->faqTopic])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_update_the_existing_faq_topic_record()
    {
        $data = $this->fakeRawData(FaqTopic::class);
        $translations = $this->fakeTranslationData(FaqTopic::class);

        Livewire::test('cms.faq-topics.edit-faq-topic', ['faqTopic' => $this->faqTopic])
            ->set('faqTopic.slug', $data['slug'])
            ->set('faqTopic.slug', $data['slug'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/faq_topics');

        $this->assertDatabaseHas('faq_topics', $data);
        $this->assertDatabaseHas('faq_topic_translations', $translations['en']);
        $this->assertDatabaseHas('faq_topic_translations', $translations['id']);

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The faq topic has been updated.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_updating_existing_faq_topic_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(FaqTopic::class);
        $translations = $this->fakeTranslationData(FaqTopic::class);

        Livewire::test('cms.faq-topics.edit-faq-topic', ['faqTopic' => $this->faqTopic])
            ->set('faqTopic.slug', $data['slug'])
            ->set('faqTopic.slug', $data['slug'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/faq_topics');

        $this->assertDatabaseMissing('faq_topics', $data);
        $this->assertDatabaseMissing('faq_topic_translations', $translations['en']);
        $this->assertDatabaseMissing('faq_topic_translations', $translations['id']);
    }
}
