<?php

namespace App\Http\Livewire\Cms\Faqs;

use App\Models\Admin;
use App\Models\Faq;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowFaqTest extends TestCase
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
     * The Faq instance to support any test cases.
     *
     * @var Faq
     */
    protected Faq $faq;

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

        $this->faq = Faq::factory()->create();
    }

    /** @test */
    public function show_component_is_accessible()
    {
        Livewire::test('cms.faqs.show-faq', ['faq' => $this->faq])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_faq_page()
    {
        Livewire::test('cms.faqs.show-faq', ['faq' => $this->faq])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/faqs/'.$this->faq->getKey().'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.faqs.show-faq', ['faq' => $this->faq])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/faqs');
    }
}
