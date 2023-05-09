<?php

namespace Tests\Livewire\Cms\PartitionB\TipsServices;

use App\Models\Admin;
use App\Models\TipsService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class EditTipsServiceTest extends TestCase
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
    public function edit_component_is_accessible()
    {
        Livewire::test('cms.tips-services.edit-tips-service', ['tipsService' => $this->tipsService])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_update_the_existing_tips_service_record()
    {
        $data = $this->fakeRawData(TipsService::class);
        $translations = $this->fakeTranslationData(TipsService::class);

        Livewire::test('cms.tips-services.edit-tips-service', ['tipsService' => $this->tipsService])
            ->set('tipsService.image_type', $data['image_type'])
            ->set('tipsService.order', $data['order'])
            ->set('tipsService.image_type', $data['image_type'])
            ->set('tipsService.order', $data['order'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->set('translations.description.en', $translations['en']['description'])
            ->set('translations.description.id', $translations['id']['description'])
            ->set('translations.url.en', $translations['en']['url'])
            ->set('translations.url.id', $translations['id']['url'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/tips_services');

        $this->assertDatabaseHas('tips_services', $data);
        $this->assertDatabaseHas('tips_service_translations', $translations['en']);
        $this->assertDatabaseHas('tips_service_translations', $translations['id']);

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The tips service has been updated.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_updating_existing_tips_service_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(TipsService::class);
        $translations = $this->fakeTranslationData(TipsService::class);

        Livewire::test('cms.tips-services.edit-tips-service', ['tipsService' => $this->tipsService])
            ->set('tipsService.image_type', $data['image_type'])
            ->set('tipsService.order', $data['order'])
            ->set('tipsService.image_type', $data['image_type'])
            ->set('tipsService.order', $data['order'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->set('translations.description.en', $translations['en']['description'])
            ->set('translations.description.id', $translations['id']['description'])
            ->set('translations.url.en', $translations['en']['url'])
            ->set('translations.url.id', $translations['id']['url'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/tips_services');

        $this->assertDatabaseMissing('tips_services', $data);
        $this->assertDatabaseMissing('tips_service_translations', $translations['en']);
        $this->assertDatabaseMissing('tips_service_translations', $translations['id']);
    }
}
