<?php

namespace Tests\Livewire\Cms\Tags;

use App\Models\Admin;
use App\Models\Tag;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class EditTagTest extends TestCase
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
     * The Tag instance to support any test cases.
     *
     * @var Tag
     */
    protected Tag $tag;

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

        $this->tag = Tag::factory()->create();
    }

    /** @test */
    public function edit_component_is_accessible()
    {
        Livewire::test('cms.tags.edit-tag', ['tag' => $this->tag])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_update_the_existing_tag_record()
    {
        $data = $this->fakeRawData(Tag::class);
        // fake translations data

        Livewire::test('cms.tags.edit-tag', ['tag' => $this->tag])
            ->set('translations.name.en', $translations['en']['name'])
            ->set('translations.name.id', $translations['id']['name'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/tags');

        $this->assertDatabaseHas('tags', $data);
        // assert translation data exists

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The tag has been updated.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_updating_existing_tag_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(Tag::class);
        // fake translations data

        Livewire::test('cms.tags.edit-tag', ['tag' => $this->tag])
            ->set('translations.name.en', $translations['en']['name'])
            ->set('translations.name.id', $translations['id']['name'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/tags');

        $this->assertDatabaseMissing('tags', $data);
        // assert translation data missing
    }
}
