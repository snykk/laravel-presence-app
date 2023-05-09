<?php

namespace App\Http\Livewire\Cms\TipsServices;

use App\Models\Admin;
use App\Models\TipsService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowTipsServiceTest extends TestCase
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
     * The Tips Service instance to support any test cases.
     *
     * @var TipsService
     */
    protected TipsService $tipsService;

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

        $this->tipsService = TipsService::factory()->create();
    }

    /** @test */
    public function show_component_is_accessible()
    {
        Livewire::test('cms.tips-services.show-tips-service', ['tipsService' => $this->tipsService])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_tips_service_page()
    {
        Livewire::test('cms.tips-services.show-tips-service', ['tipsService' => $this->tipsService])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/tips_services/'.$this->tipsService->getKey().'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.tips-services.show-tips-service', ['tipsService' => $this->tipsService])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/tips_services');
    }
}
