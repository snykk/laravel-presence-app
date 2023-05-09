<?php

namespace App\Http\Livewire\Cms\TopupVendors;

use App\Models\Admin;
use App\Models\TopupVendor;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowTopupVendorTest extends TestCase
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
     * The Topup Vendor instance to support any test cases.
     *
     * @var TopupVendor
     */
    protected TopupVendor $topupVendor;

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

        $this->topupVendor = TopupVendor::factory()->create();
    }

    /** @test */
    public function show_component_is_accessible()
    {
        Livewire::test('cms.topup-vendors.show-topup-vendor', ['topupVendor' => $this->topupVendor])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_topup_vendor_page()
    {
        Livewire::test('cms.topup-vendors.show-topup-vendor', ['topupVendor' => $this->topupVendor])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/topup_vendors/'.$this->topupVendor->getKey().'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.topup-vendors.show-topup-vendor', ['topupVendor' => $this->topupVendor])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/topup_vendors');
    }
}
