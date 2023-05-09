<?php

namespace Tests\Livewire\Cms\PartitionC\Promos;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Location;
use App\Models\Promo;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class EditPromoTest extends TestCase
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
     * The Promo instance to support any test cases.
     *
     * @var Promo
     */
    protected Promo $promo;

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

        $this->promo = Promo::factory()->create();

        Location::factory(10)->create();
        Category::factory(5)->create();
    }

    /** @test */
    public function edit_component_is_accessible()
    {
        Livewire::test('cms.promos.edit-promo', ['promoId' => $this->promo->id])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_update_the_existing_promo_record()
    {
        $data = $this->fakeRawData(Promo::class);
        $translations = $this->fakeTranslationData(Promo::class);

        $test = Livewire::test('cms.promos.edit-promo', ['promoId' => $this->promo->id])
            ->set('selectedLocations', Location::inRandomOrder()->limit(2)->pluck('id')->toArray())
            ->set('selectedCategories', Category::inRandomOrder()->limit(2)->pluck('id')->toArray())
            ->set('promo.brand_id', $data['brand_id'])
            ->set('promo.rank', $data['rank'])
            ->set('promo.cta_url', $data['cta_url'])
            ->set('promo.start_date', $data['start_date'])
            ->set('promo.end_date', $data['end_date'])
            ->set('banner.rank', 10);

        foreach ($translations as $locale => $translation) {
            $test = $test
                ->set('translations.headline.'.$locale, $translation['headline'])
                ->set('translations.title.'.$locale, $translation['title'])
                ->set('translations.cta_title.'.$locale, $translation['cta_title'])
                ->set('translations.terms.'.$locale, $translation['terms']);
        }

        $test->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/promos');

        $this->assertDatabaseHas('promos', $data);
        foreach ($translations as $locale => $translation) {
            unset($translation['slug']);
            $this->assertDatabaseHas('promo_translations', $translation);
        }

        self::assertEquals('success', session('alertType'));
        self::assertEquals('The promo has been updated.', session('alertMessage'));
    }

    /** @test */
    public function it_can_cancel_updating_existing_promo_and_go_back_to_index_page()
    {
        $data = $this->fakeRawData(Promo::class);
        $translations = $this->fakeTranslationData(Promo::class);

        $test = Livewire::test('cms.promos.edit-promo', ['promoId' => $this->promo->id])
            ->set('selectedLocations', Location::inRandomOrder()->limit(2)->pluck('id')->toArray())
            ->set('selectedCategories', Category::inRandomOrder()->limit(2)->pluck('id')->toArray())
            ->set('promo.brand_id', $data['brand_id'])
            ->set('promo.rank', $data['rank'])
            ->set('promo.cta_url', $data['cta_url'])
            ->set('promo.start_date', $data['start_date'])
            ->set('promo.end_date', $data['end_date'])
            ->set('banner.rank', 10);

        foreach ($translations as $locale => $translation) {
            $test = $test
                ->set('translations.headline.'.$locale, $translation['headline'])
                ->set('translations.title.'.$locale, $translation['title'])
                ->set('translations.cta_title.'.$locale, $translation['cta_title'])
                ->set('translations.terms.'.$locale, $translation['terms']);
        }

        $test->call('backToIndex')
            ->assertHasNoErrors()
            ->assertRedirect('/cms/promos');

        $this->assertDatabaseMissing('promos', $data);
        foreach ($translations as $locale => $translation) {
            unset($translation['slug']);
            $this->assertDatabaseMissing('promo_translations', $translation);
        }
    }
}
