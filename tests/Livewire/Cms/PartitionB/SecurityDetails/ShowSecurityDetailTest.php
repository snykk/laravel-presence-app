<?php

namespace App\Http\Livewire\Cms\SecurityDetails;

use App\Models\Admin;
use App\Models\SecurityDetail;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowSecurityDetailTest extends TestCase
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
     * The Security Detail instance to support any test cases.
     *
     * @var SecurityDetail
     */
    protected SecurityDetail $securityDetail;

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

        $this->securityDetail = SecurityDetail::factory()->create();
    }

    /** @test */
    public function show_component_is_accessible()
    {
        Livewire::test('cms.security-details.show-security-detail', ['securityDetail' => $this->securityDetail])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_security_detail_page()
    {
        Livewire::test('cms.security-details.show-security-detail', ['securityDetail' => $this->securityDetail])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/security_details/'.$this->securityDetail->getKey().'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.security-details.show-security-detail', ['securityDetail' => $this->securityDetail])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/security_details');
    }
}
