<?php

namespace Tests\Livewire\Cms\Tags;

use App\Models\Admin;
use App\Models\Tag;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class CreateTagTest extends TestCase
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
        Livewire::test('cms.tags.create-tag')
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_save_the_new_tag_record()
    {
        $data = $this->fakeRawData(Tag::class);
        // fake translations data

        Livewire::test('cms.tags.create-tag')
            ->set('translations.name.en', $translations['en']['name'])
            ->set('translations.name.id', $translations['id']['name'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/tags');

        $this->assertDatabaseHas('tags', $data);
        // assert translation data exists

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The new tag has been saved.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_creating_new_tag_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(Tag::class);
        // fake translations data

        Livewire::test('cms.tags.create-tag')
            ->set('translations.name.en', $translations['en']['name'])
            ->set('translations.name.id', $translations['id']['name'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/tags');

        $this->assertDatabaseMissing('tags', $data);
        // assert translation data missing
    }
}
