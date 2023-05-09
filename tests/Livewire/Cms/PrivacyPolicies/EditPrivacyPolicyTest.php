<?php

namespace Tests\Livewire\Cms\PrivacyPolicies;

use App\Models\Admin;
use App\Models\PrivacyPolicy;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class EditPrivacyPolicyTest extends TestCase
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
     * The Privacy Policy instance to support any test cases.
     *
     * @var PrivacyPolicy
     */
    protected PrivacyPolicy $privacyPolicy;

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

        $this->privacyPolicy = PrivacyPolicy::factory()->create();
    }

    /** @test */
    public function edit_component_is_accessible()
    {
        Livewire::test('cms.privacy-policies.edit-privacy-policy', ['privacyPolicy' => $this->privacyPolicy])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_update_the_existing_privacy_policy_record()
    {
        $data = $this->fakeRawData(PrivacyPolicy::class);

        Livewire::test('cms.privacy-policies.edit-privacy-policy', ['privacyPolicy' => $this->privacyPolicy])
            ->set('privacyPolicy.slug', $data['slug'])
            ->set('privacyPolicy.order', $data['order'])
            ->set('privacyPolicy.published', $data['published'])
            ->set('privacyPolicy.published_at', $data['published_at'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/privacy_policies');

        $this->assertDatabaseHas('privacy_policies', $data);

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The privacy policy has been updated.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_updating_existing_privacy_policy_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(PrivacyPolicy::class);

        Livewire::test('cms.privacy-policies.edit-privacy-policy', ['privacyPolicy' => $this->privacyPolicy])
            ->set('privacyPolicy.slug', $data['slug'])
            ->set('privacyPolicy.order', $data['order'])
            ->set('privacyPolicy.published', $data['published'])
            ->set('privacyPolicy.published_at', $data['published_at'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/privacy_policies');

        $this->assertDatabaseMissing('privacy_policies', $data);
    }
}
