<?php

namespace Tests\Livewire\Cms\PartitionB\SecurityDetails;

use App\Models\Admin;
use App\Models\SecurityDetail;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class CreateSecurityDetailTest extends TestCase
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
        Livewire::test('cms.security-details.create-security-detail')
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_save_the_new_security_detail_record()
    {
        $data = $this->fakeRawData(SecurityDetail::class);
        $translations = $this->fakeTranslationData(SecurityDetail::class);

        Livewire::test('cms.security-details.create-security-detail')
            ->set('securityDetail.order', $data['order'])
            ->set('securityDetail.order', $data['order'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->set('translations.description.en', $translations['en']['description'])
            ->set('translations.description.id', $translations['id']['description'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/security_details');

        $this->assertDatabaseHas('security_details', $data);
        $this->assertDatabaseHas('security_detail_translations', $translations['en']);
        $this->assertDatabaseHas('security_detail_translations', $translations['id']);

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The new security detail has been saved.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_creating_new_security_detail_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(SecurityDetail::class);
        $translations = $this->fakeTranslationData(SecurityDetail::class);

        Livewire::test('cms.security-details.create-security-detail')
            ->set('securityDetail.order', $data['order'])
            ->set('securityDetail.order', $data['order'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->set('translations.description.en', $translations['en']['description'])
            ->set('translations.description.id', $translations['id']['description'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/security_details');

        $this->assertDatabaseMissing('security_details', $data);
        $this->assertDatabaseMissing('security_detail_translations', $translations['en']);
        $this->assertDatabaseMissing('security_detail_translations', $translations['id']);
    }
}
