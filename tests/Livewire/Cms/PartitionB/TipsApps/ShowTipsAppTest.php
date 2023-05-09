<?php

namespace App\Http\Livewire\Cms\TipsApps;

use App\Models\Admin;
use App\Models\TipsApp;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowTipsAppTest extends TestCase
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
     * The Tips App instance to support any test cases.
     *
     * @var TipsApp
     */
    protected TipsApp $tipsApp;

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

        $this->tipsApp = TipsApp::factory()->create();
    }

    /** @test */
    public function show_component_is_accessible()
    {
        Livewire::test('cms.tips-apps.show-tips-app', ['tipsApp' => $this->tipsApp])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_tips_app_page()
    {
        Livewire::test('cms.tips-apps.show-tips-app', ['tipsApp' => $this->tipsApp])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/tips_apps/'.$this->tipsApp->getKey().'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.tips-apps.show-tips-app', ['tipsApp' => $this->tipsApp])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/tips_apps');
    }
}
