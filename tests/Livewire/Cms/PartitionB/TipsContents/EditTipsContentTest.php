<?php

namespace Tests\Livewire\Cms\PartitionB\TipsContents;

use App\Models\Admin;
use App\Models\TipsContent;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class EditTipsContentTest extends TestCase
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
    public function edit_component_is_accessible()
    {
        Livewire::test('cms.tips-contents.edit-tips-content', ['tipsContent' => $this->tipsContent])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_update_the_existing_tips_content_record()
    {
        $data = $this->fakeRawData(TipsContent::class);
        $translations = $this->fakeTranslationData(TipsContent::class);

        Livewire::test('cms.tips-contents.edit-tips-content', ['tipsContent' => $this->tipsContent])
            ->set('tipsContent.order', $data['order'])
            ->set('tipsContent.order', $data['order'])
            ->set('tipsContent.tips_app_id', $data['tips_app_id'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->set('translations.description.en', $translations['en']['description'])
            ->set('translations.description.id', $translations['id']['description'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/tips_contents');

        $this->assertDatabaseHas('tips_contents', $data);
        $this->assertDatabaseHas('tips_content_translations', $translations['en']);
        $this->assertDatabaseHas('tips_content_translations', $translations['id']);

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The tips content has been updated.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_updating_existing_tips_content_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(TipsContent::class);
        $translations = $this->fakeTranslationData(TipsContent::class);

        Livewire::test('cms.tips-contents.edit-tips-content', ['tipsContent' => $this->tipsContent])
            ->set('tipsContent.order', $data['order'])
            ->set('tipsContent.order', $data['order'])
            ->set('tipsContent.tips_app_id', $data['tips_app_id'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->set('translations.description.en', $translations['en']['description'])
            ->set('translations.description.id', $translations['id']['description'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/tips_contents');

        $this->assertDatabaseMissing('tips_contents', $data);
        $this->assertDatabaseMissing('tips_content_translations', $translations['en']);
        $this->assertDatabaseMissing('tips_content_translations', $translations['id']);
    }
}
