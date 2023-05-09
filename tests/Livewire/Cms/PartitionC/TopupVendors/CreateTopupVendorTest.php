<?php

namespace Tests\Livewire\Cms\PartitionC\TopupVendors;

use App\Models\Admin;
use App\Models\TopupVendor;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class CreateTopupVendorTest extends TestCase
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
    }

    /** @test */
    public function create_component_is_accessible()
    {
        Livewire::test('cms.topup-vendors.create-topup-vendor')
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_save_the_new_topup_vendor_record()
    {
        $data = $this->fakeRawData(TopupVendor::class);
        $translations = $this->fakeTranslationData(TopupVendor::class);

        Livewire::test('cms.topup-vendors.create-topup-vendor')
            ->set('topupVendor.admin_fee', $data['admin_fee'])
            ->set('topupVendor.minimum', $data['minimum'])
            ->set('topupVendor.order', $data['order'])
            ->set('topupVendor.topup_anchor_id', $data['topup_anchor_id'])
            ->set('topupVendor.admin_fee', $data['admin_fee'])
            ->set('topupVendor.minimum', $data['minimum'])
            ->set('translations.name.en', $translations['en']['name'])
            ->set('translations.name.id', $translations['id']['name'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/topup_vendors');

        $this->assertDatabaseHas('topup_vendors', $data);
        $this->assertDatabaseHas('topup_vendor_translations', $translations['en']);
        $this->assertDatabaseHas('topup_vendor_translations', $translations['id']);

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The new topup vendor has been saved.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_creating_new_topup_vendor_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(TopupVendor::class);
        $translations = $this->fakeTranslationData(TopupVendor::class);

        Livewire::test('cms.topup-vendors.create-topup-vendor')
            ->set('topupVendor.admin_fee', $data['admin_fee'])
            ->set('topupVendor.minimum', $data['minimum'])
            ->set('topupVendor.order', $data['order'])
            ->set('topupVendor.admin_fee', $data['admin_fee'])
            ->set('topupVendor.minimum', $data['minimum'])
            ->set('translations.name.en', $translations['en']['name'])
            ->set('translations.name.id', $translations['id']['name'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/topup_vendors');

        $this->assertDatabaseMissing('topup_vendors', $data);
        $this->assertDatabaseMissing('topup_vendor_translations', $translations['en']);
        $this->assertDatabaseMissing('topup_vendor_translations', $translations['id']);
    }
}
