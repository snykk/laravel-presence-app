<?php

namespace Tests\Livewire\Cms\PartitionC\Menus;

use App\Models\Admin;
use App\Models\Menu;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class EditMenuTest extends TestCase
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
     * The Menu instance to support any test cases.
     *
     * @var Menu
     */
    protected Menu $menu;

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

        $this->menu = Menu::factory()->create();
    }

    /** @test */
    public function edit_component_is_accessible()
    {
        Livewire::test('cms.menus.edit-menu', ['menu' => $this->menu])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_update_the_existing_menu_record()
    {
        $data = $this->fakeRawData(Menu::class);
        $translations = $this->fakeTranslationData(Menu::class);

        Livewire::test('cms.menus.edit-menu', ['menu' => $this->menu])
            ->set('menu.order', $data['order'])
            ->set('isPublished', (isset($data['published_at'])) ? 'true' : 'false')
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->set('translations.url.en', $translations['en']['url'])
            ->set('translations.url.id', $translations['id']['url'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/menus');

        unset($data['published_at']);
        $this->assertDatabaseHas('menus', $data);
        $this->assertDatabaseHas('menu_translations', $translations['en']);
        $this->assertDatabaseHas('menu_translations', $translations['id']);

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The menu has been updated.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_updating_existing_menu_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(Menu::class);
        $translations = $this->fakeTranslationData(Menu::class);

        Livewire::test('cms.menus.edit-menu', ['menu' => $this->menu])
            ->set('menu.order', $data['order'])
            ->set('isPublished', (isset($data['published_at'])) ? 'true' : 'false')
            ->set('translations.title.en', $translations['en']['title'])
            ->set('translations.title.id', $translations['id']['title'])
            ->set('translations.url.en', $translations['en']['url'])
            ->set('translations.url.id', $translations['id']['url'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/menus');

        unset($data['published_at']);
        $this->assertDatabaseMissing('menus', $data);
        $this->assertDatabaseMissing('menu_translations', $translations['en']);
        $this->assertDatabaseMissing('menu_translations', $translations['id']);
    }
}
