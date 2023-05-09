<?php

namespace Tests\Livewire\Cms\PrivacyDetails;

use App\Models\Admin;
use App\Models\PrivacyDetail;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class EditPrivacyDetailTest extends TestCase
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
     * The Privacy Detail instance to support any test cases.
     *
     * @var PrivacyDetail
     */
    protected PrivacyDetail $privacyDetail;

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

        $this->privacyDetail = PrivacyDetail::factory()->create();
    }

    /** @test */
    public function edit_component_is_accessible()
    {
        Livewire::test('cms.privacy-details.edit-privacy-detail', ['privacyDetail' => $this->privacyDetail])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_update_the_existing_privacy_detail_record()
    {
        $data = $this->fakeRawData(PrivacyDetail::class);
        $translations = $this->fakeTranslationData(PrivacyDetail::class);

        Livewire::test('cms.privacy-details.edit-privacy-detail', ['privacyDetail' => $this->privacyDetail])
            ->set('privacyDetail.privacy_policy_id', $data['privacy_policy_id'])
            ->set('privacyDetail.published', $data['published'])
            ->set('privacyDetail.published_at', $data['published_at'])
            ->set('privacyDetail.order', $data['order'])
            ->set('privacyDetail.privacy_policy_id', $data['privacy_policy_id'])
            ->set('privacyDetail.published', $data['published'])
            ->set('privacyDetail.published_at', $data['published_at'])
            ->set('privacyDetail.order', $data['order'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->set('translations.content.en', $translations['en']['content'])
            ->set('translations.content.id', $translations['id']['content'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/privacy_details');

        $this->assertDatabaseHas('privacy_details', $data);
        $this->assertDatabaseHas('privacy_detail_translations', $translations['en']);
        $this->assertDatabaseHas('privacy_detail_translations', $translations['id']);

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The privacy detail has been updated.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_updating_existing_privacy_detail_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(PrivacyDetail::class);
        $translations = $this->fakeTranslationData(PrivacyDetail::class);

        Livewire::test('cms.privacy-details.edit-privacy-detail', ['privacyDetail' => $this->privacyDetail])
            ->set('privacyDetail.privacy_policy_id', $data['privacy_policy_id'])
            ->set('privacyDetail.published', $data['published'])
            ->set('privacyDetail.published_at', $data['published_at'])
            ->set('privacyDetail.order', $data['order'])
            ->set('privacyDetail.privacy_policy_id', $data['privacy_policy_id'])
            ->set('privacyDetail.published', $data['published'])
            ->set('privacyDetail.published_at', $data['published_at'])
            ->set('privacyDetail.order', $data['order'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->set('translations.content.en', $translations['en']['content'])
            ->set('translations.content.id', $translations['id']['content'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/privacy_details');

        $this->assertDatabaseMissing('privacy_details', $data);
        $this->assertDatabaseMissing('privacy_detail_translations', $translations['en']);
        $this->assertDatabaseMissing('privacy_detail_translations', $translations['id']);
    }
}
