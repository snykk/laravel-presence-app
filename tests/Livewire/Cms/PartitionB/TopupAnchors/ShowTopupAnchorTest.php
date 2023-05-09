<?php

namespace App\Http\Livewire\Cms\TopupAnchors;

use App\Models\Admin;
use App\Models\TopupAnchor;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowTopupAnchorTest extends TestCase
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
     * The Topup Anchor instance to support any test cases.
     *
     * @var TopupAnchor
     */
    protected TopupAnchor $topupAnchor;

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

        $this->topupAnchor = TopupAnchor::factory()->create();
    }

    /** @test */
    public function show_component_is_accessible()
    {
        Livewire::test('cms.topup-anchors.show-topup-anchor', ['topupAnchor' => $this->topupAnchor])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_topup_anchor_page()
    {
        Livewire::test('cms.topup-anchors.show-topup-anchor', ['topupAnchor' => $this->topupAnchor])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/topup_anchors/'.$this->topupAnchor->getKey().'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.topup-anchors.show-topup-anchor', ['topupAnchor' => $this->topupAnchor])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/topup_anchors');
    }
}
