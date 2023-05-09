<?php

namespace Tests\Livewire\Cms\PartitionA\Categories;

use App\Models\Admin;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class CreateCategoryTest extends TestCase
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
        Livewire::test('cms.categories.create-category')
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_save_the_new_category_record()
    {
        $translations = $this->fakeTranslationData(Category::class);

        Livewire::test('cms.categories.create-category')
            ->set('translations.name.en', $translations['en']['name'])
            ->set('translations.name.id', $translations['id']['name'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/categories');

        $this->assertDatabaseHas('category_translations', $translations['en']);
        $this->assertDatabaseHas('category_translations', $translations['id']);

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The new category has been saved.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_creating_new_category_and_go_back_to_index_page()
    {
        $translations = $this->fakeTranslationData(Category::class);

        Livewire::test('cms.categories.create-category')
            ->set('translations.name.en', $translations['en']['name'])
            ->set('translations.name.id', $translations['id']['name'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/categories');

        $this->assertDatabaseMissing('category_translations', $translations['en']);
        $this->assertDatabaseMissing('category_translations', $translations['id']);
    }
}
