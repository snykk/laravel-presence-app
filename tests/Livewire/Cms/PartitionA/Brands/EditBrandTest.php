<?php

namespace Tests\Livewire\Cms\PartitionA\Brands;

use App\Models\Admin;
use App\Models\Brand;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class EditBrandTest extends TestCase
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
    public function edit_component_is_accessible()
    {
        Livewire::test('cms.brands.edit-brand', ['brand' => $this->brand])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_update_the_existing_brand_record()
    {
        $brand = Brand::factory()->raw();

        Livewire::test('cms.brands.edit-brand', ['brand' => $this->brand])
            ->set('brand.title', $brand['title'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/brands');

        $this->assertDatabaseHas('brands', $brand);

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The brand has been updated.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_updating_existing_brand_and_go_back_to_index_page()
    {
        $brand = Brand::factory()->raw();

        Livewire::test('cms.brands.edit-brand', ['brand' => $this->brand])
            ->set('brand.title', $brand['title'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/brands');

        $this->assertDatabaseMissing('brands', $brand);
    }
}
