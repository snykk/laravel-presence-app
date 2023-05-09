<?php

namespace App\Http\Livewire\Cms\PrivacyDetails;

use App\Models\Admin;
use App\Models\PrivacyDetail;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowPrivacyDetailTest extends TestCase
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
    public function show_component_is_accessible()
    {
        Livewire::test('cms.privacy-details.show-privacy-detail', ['privacyDetail' => $this->privacyDetail])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_privacy_detail_page()
    {
        Livewire::test('cms.privacy-details.show-privacy-detail', ['privacyDetail' => $this->privacyDetail])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/privacy_details/'.$this->privacyDetail->getKey().'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.privacy-details.show-privacy-detail', ['privacyDetail' => $this->privacyDetail])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/privacy_details');
    }
}
