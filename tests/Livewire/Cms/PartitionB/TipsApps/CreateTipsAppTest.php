<?php

namespace Tests\Livewire\Cms\PartitionB\TipsApps;

use App\Models\Admin;
use App\Models\TipsApp;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class CreateTipsAppTest extends TestCase
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
        Livewire::test('cms.tips-apps.create-tips-app')
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_save_the_new_tips_app_record()
    {
        $data = $this->fakeRawData(TipsApp::class);
        $translations = $this->fakeTranslationData(TipsApp::class);

        Livewire::test('cms.tips-apps.create-tips-app')
            ->set('tipsApp.order', $data['order'])
            ->set('tipsApp.order', $data['order'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->set('translations.description.en', $translations['en']['description'])
            ->set('translations.description.id', $translations['id']['description'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/tips_apps');

        unset($data['published_at']);
        $this->assertDatabaseHas('tips_apps', $data);
        $this->assertDatabaseHas('tips_app_translations', $translations['en']);
        $this->assertDatabaseHas('tips_app_translations', $translations['id']);

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The new tips app has been saved.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_creating_new_tips_app_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(TipsApp::class);
        $translations = $this->fakeTranslationData(TipsApp::class);

        Livewire::test('cms.tips-apps.create-tips-app')
            ->set('tipsApp.order', $data['order'])
            ->set('tipsApp.order', $data['order'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->set('translations.description.en', $translations['en']['description'])
            ->set('translations.description.id', $translations['id']['description'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/tips_apps');

        $this->assertDatabaseMissing('tips_apps', $data);
        $this->assertDatabaseMissing('tips_app_translations', $translations['en']);
        $this->assertDatabaseMissing('tips_app_translations', $translations['id']);
    }
}
