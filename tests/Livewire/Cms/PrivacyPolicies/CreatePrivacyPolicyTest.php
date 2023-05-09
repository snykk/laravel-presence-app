<?php

namespace Tests\Livewire\Cms\PrivacyPolicies;

use App\Models\Admin;
use App\Models\PrivacyPolicy;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class CreatePrivacyPolicyTest extends TestCase
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
        Livewire::test('cms.privacy-policies.create-privacy-policy')
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_save_the_new_privacy_policy_record()
    {
        $data = $this->fakeRawData(PrivacyPolicy::class);

        Livewire::test('cms.privacy-policies.create-privacy-policy')
            ->set('privacyPolicy.slug', $data['slug'])
            ->set('privacyPolicy.order', $data['order'])
            ->set('privacyPolicy.published', $data['published'])
            ->set('privacyPolicy.published_at', $data['published_at'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/privacy_policies');

        $this->assertDatabaseHas('privacy_policies', $data);

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The new privacy policy has been saved.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_creating_new_privacy_policy_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(PrivacyPolicy::class);

        Livewire::test('cms.privacy-policies.create-privacy-policy')
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
