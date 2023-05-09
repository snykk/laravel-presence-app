<?php

namespace App\Http\Livewire\Cms\FaqTopics;

use App\Models\Admin;
use App\Models\FaqTopic;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowFaqTopicTest extends TestCase
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
    public function show_component_is_accessible()
    {
        Livewire::test('cms.faq-topics.show-faq-topic', ['faqTopic' => $this->faqTopic])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_faq_topic_page()
    {
        Livewire::test('cms.faq-topics.show-faq-topic', ['faqTopic' => $this->faqTopic])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/faq_topics/'.$this->faqTopic->getKey().'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.faq-topics.show-faq-topic', ['faqTopic' => $this->faqTopic])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/faq_topics');
    }
}
