<?php

namespace App\Http\Livewire\Cms\PrivacyPolicies;

use App\Models\Admin;
use App\Models\PrivacyPolicy;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowPrivacyPolicyTest extends TestCase
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
    public function show_component_is_accessible()
    {
        Livewire::test('cms.privacy-policies.show-privacy-policy', ['privacyPolicy' => $this->privacyPolicy])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_privacy_policy_page()
    {
        Livewire::test('cms.privacy-policies.show-privacy-policy', ['privacyPolicy' => $this->privacyPolicy])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/privacy_policies/'.$this->privacyPolicy->getKey().'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.privacy-policies.show-privacy-policy', ['privacyPolicy' => $this->privacyPolicy])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/privacy_policies');
    }
}
