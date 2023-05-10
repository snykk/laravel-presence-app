<?php

namespace Tests\Livewire\Cms\PartitionB\TopupAnchors;

use App\Models\Admin;
use App\Models\TopupAnchor;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class CreateTopupAnchorTest extends TestCase
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
        Livewire::test('cms.topup-anchors.create-topup-anchor')
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_save_the_new_topup_anchor_record()
    {
        $data = $this->fakeRawData(TopupAnchor::class);
        $translations = $this->fakeTranslationData(TopupAnchor::class);

        Livewire::test('cms.topup-anchors.create-topup-anchor')
            ->set('topupAnchor.admin_fee', $data['admin_fee'])
            ->set('topupAnchor.minimum', $data['minimum'])
            ->set('topupAnchor.order', $data['order'])
            ->set('topupAnchor.admin_fee', $data['admin_fee'])
            ->set('topupAnchor.minimum', $data['minimum'])
            ->set('translations.anchor.en', $translations['en']['anchor'])
            ->set('translations.anchor.id', $translations['id']['anchor'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->set('translations.headline.en', $translations['en']['headline'])
            ->set('translations.headline.id', $translations['id']['headline'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/topup_anchors');

        $this->assertDatabaseHas('topup_anchors', $data);
        $this->assertDatabaseHas('topup_anchor_translations', $translations['en']);
        $this->assertDatabaseHas('topup_anchor_translations', $translations['id']);

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The new topup anchor has been saved.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_creating_new_topup_anchor_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(TopupAnchor::class);
        $translations = $this->fakeTranslationData(TopupAnchor::class);

        Livewire::test('cms.topup-anchors.create-topup-anchor')
            ->set('topupAnchor.admin_fee', $data['admin_fee'])
            ->set('topupAnchor.minimum', $data['minimum'])
            ->set('topupAnchor.admin_fee', $data['admin_fee'])
            ->set('topupAnchor.minimum', $data['minimum'])
            ->set('translations.anchor.en', $translations['en']['anchor'])
            ->set('translations.anchor.id', $translations['id']['anchor'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->set('translations.headline.en', $translations['en']['headline'])
            ->set('translations.headline.id', $translations['id']['headline'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/topup_anchors');

        $this->assertDatabaseMissing('topup_anchors', $data);
        $this->assertDatabaseMissing('topup_anchor_translations', $translations['en']);
        $this->assertDatabaseMissing('topup_anchor_translations', $translations['id']);
    }
}