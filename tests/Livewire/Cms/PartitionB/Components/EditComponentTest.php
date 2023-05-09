<?php

namespace Tests\Livewire\Cms\PartitionB\Components;

use App\Models\Admin;
use App\Models\Component;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class EditComponentTest extends TestCase
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
     * The Component instance to support any test cases.
     *
     * @var Component
     */
    protected Component $component;

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

        $this->component = Component::factory()->create();
    }

    /** @test */
    public function edit_component_is_accessible()
    {
        Livewire::test('cms.components.edit-component', ['componentId' => $this->component->id])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_update_the_existing_component_record()
    {
        $data = $this->fakeRawData(Component::class);
        $translations = $this->fakeTranslationData(Component::class);

        Livewire::test('cms.components.edit-component', ['componentId' => $this->component->id])
            ->set('component.name', $data['name'])
            ->set('component.slug', $data['slug'])
            ->set('component.name', $data['name'])
            ->set('component.slug', $data['slug'])
            ->set('component.type', $data['type'])
            ->set('component.order', $data['order'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->set('translations.description.en', $translations['en']['description'])
            ->set('translations.description.id', $translations['id']['description'])
            ->set('translations.content.en', $translations['en']['content'])
            ->set('translations.content.id', $translations['id']['content'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/components');

        unset($data['published_at']);
        $this->assertDatabaseHas('components', $data);
        $this->assertDatabaseHas('component_translations', $translations['en']);
        $this->assertDatabaseHas('component_translations', $translations['id']);

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The component has been updated.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_updating_existing_component_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(Component::class);
        $translations = $this->fakeTranslationData(Component::class);

        Livewire::test('cms.components.edit-component', ['componentId' => $this->component->id])
            ->set('component.name', $data['name'])
            ->set('component.slug', $data['slug'])
            ->set('component.name', $data['name'])
            ->set('component.slug', $data['slug'])
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->set('translations.description.en', $translations['en']['description'])
            ->set('translations.description.id', $translations['id']['description'])
            ->set('translations.content.en', $translations['en']['content'])
            ->set('translations.content.id', $translations['id']['content'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/components');

        $this->assertDatabaseMissing('components', $data);
        $this->assertDatabaseMissing('component_translations', $translations['en']);
        $this->assertDatabaseMissing('component_translations', $translations['id']);
    }
}
