<?php

namespace App\Http\Livewire\Cms\Brands;

use App\Models\Admin;
use App\Models\Brand;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class ShowBrandTest extends TestCase
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
     * The Brand instance to support any test cases.
     *
     * @var Brand
     */
    protected Brand $brand;

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

        $this->brand = Brand::factory()->create();
    }

    /** @test */
    public function show_component_is_accessible()
    {
        Livewire::test('cms.brands.show-brand', ['brand' => $this->brand])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_guide_admin_to_the_edit_brand_page()
    {
        Livewire::test('cms.brands.show-brand', ['brand' => $this->brand])
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/brands/'.$this->brand->getKey().'/edit');
    }

    /** @test */
    public function it_can_go_back_to_index_page()
    {
        Livewire::test('cms.brands.show-brand', ['brand' => $this->brand])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/brands');
    }
}
