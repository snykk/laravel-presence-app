<?php

namespace Tests\Livewire\Cms\PartitionC\Ctas;

use App\Models\Admin;
use App\Models\Cta;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class EditCtaTest extends TestCase
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
     * The Cta instance to support any test cases.
     *
     * @var Cta
     */
    protected Cta $cta;

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

        $this->cta = Cta::factory()->create();
    }

    /** @test */
    public function edit_component_is_accessible()
    {
        Livewire::test('cms.ctas.edit-cta', ['cta' => $this->cta])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_update_the_existing_cta_record()
    {
        $data = $this->fakeRawData(Cta::class);
        $translations = $this->fakeTranslationData(Cta::class);

        Livewire::test('cms.ctas.edit-cta', ['cta' => $this->cta])
            ->set('cta.ctable_type', $data['ctable_type'])
            ->set('cta.ctable_id', $data['ctable_id'])
            ->set('cta.action_type', $data['action_type'])
            ->set('cta.slug', $data['slug'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->set('translations.url.en', $translations['en']['url'])
            ->set('translations.url.id', $translations['id']['url'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/ctas');

        $this->assertDatabaseHas('ctas', $data);
        $this->assertDatabaseHas('cta_translations', $translations['en']);
        $this->assertDatabaseHas('cta_translations', $translations['id']);

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The cta has been updated.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_updating_existing_cta_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(Cta::class);
        $translations = $this->fakeTranslationData(Cta::class);

        Livewire::test('cms.ctas.edit-cta', ['cta' => $this->cta])
            ->set('cta.ctable_type', $data['ctable_type'])
            ->set('cta.ctable_id', $data['ctable_id'])
            ->set('cta.action_type', $data['action_type'])
            ->set('cta.slug', $data['slug'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->set('translations.url.en', $translations['en']['url'])
            ->set('translations.url.id', $translations['id']['url'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/ctas');

        $this->assertDatabaseMissing('ctas', $data);
        $this->assertDatabaseMissing('cta_translations', $translations['en']);
        $this->assertDatabaseMissing('cta_translations', $translations['id']);
    }
}
