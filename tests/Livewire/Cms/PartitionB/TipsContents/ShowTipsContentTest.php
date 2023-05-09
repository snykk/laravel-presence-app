<?php

namespace App\Http\Livewire\Cms\TipsContents;

use App\Models\Admin;
use App\Models\TipsContent;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowTipsContentTest extends TestCase
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
     * The Tips Content instance to support any test cases.
     *
     * @var TipsContent
     */
    protected TipsContent $tipsContent;

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

        $this->tipsContent = TipsContent::factory()->create();
    }

    /** @test */
    public function show_component_is_accessible()
    {
        Livewire::test('cms.tips-contents.show-tips-content', ['tipsContent' => $this->tipsContent])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_tips_content_page()
    {
        Livewire::test('cms.tips-contents.show-tips-content', ['tipsContent' => $this->tipsContent])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/tips_contents/'.$this->tipsContent->getKey().'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.tips-contents.show-tips-content', ['tipsContent' => $this->tipsContent])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/tips_contents');
    }
}
