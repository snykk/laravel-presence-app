<?php

namespace Tests\Livewire\Cms\PartitionC\TopupMethods;

use App\Models\Admin;
use App\Models\TopupMethod;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class EditTopupMethodTest extends TestCase
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
     * The Topup Method instance to support any test cases.
     *
     * @var TopupMethod
     */
    protected TopupMethod $topupMethod;

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

        $this->topupMethod = TopupMethod::factory()->create();
    }

    /** @test */
    public function edit_component_is_accessible()
    {
        Livewire::test('cms.topup-methods.edit-topup-method', ['topupMethod' => $this->topupMethod])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_update_the_existing_topup_method_record()
    {
        $data = $this->fakeRawData(TopupMethod::class);
        $translations = $this->fakeTranslationData(TopupMethod::class);

        Livewire::test('cms.topup-methods.edit-topup-method', ['topupMethod' => $this->topupMethod])
            ->set('topupMethod.order', $data['order'])
            ->set('topupMethod.methodable_type', $data['methodable_type'])
            ->set('topupMethod.methodable_id', $data['methodable_id'])
            ->set('topupMethod.order', $data['order'])
            ->set('topupMethod.methodable_type', $data['methodable_type'])
            ->set('topupMethod.methodable_id', $data['methodable_id'])
            ->set('translations.name.en', $translations['en']['name'])
            ->set('translations.name.id', $translations['id']['name'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/topup_methods');

        $this->assertDatabaseHas('topup_methods', $data);
        $this->assertDatabaseHas('topup_method_translations', $translations['en']);
        $this->assertDatabaseHas('topup_method_translations', $translations['id']);

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The topup method has been updated.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_updating_existing_topup_method_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(TopupMethod::class);
        $translations = $this->fakeTranslationData(TopupMethod::class);

        Livewire::test('cms.topup-methods.edit-topup-method', ['topupMethod' => $this->topupMethod])
            ->set('topupMethod.order', $data['order'])
            ->set('topupMethod.methodable_type', $data['methodable_type'])
            ->set('topupMethod.methodable_id', $data['methodable_id'])
            ->set('topupMethod.order', $data['order'])
            ->set('topupMethod.methodable_type', $data['methodable_type'])
            ->set('topupMethod.methodable_id', $data['methodable_id'])
            ->set('translations.name.en', $translations['en']['name'])
            ->set('translations.name.id', $translations['id']['name'])
            ->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/topup_methods');

        $this->assertDatabaseMissing('topup_methods', $data);
        $this->assertDatabaseMissing('topup_method_translations', $translations['en']);
        $this->assertDatabaseMissing('topup_method_translations', $translations['id']);
    }
}
