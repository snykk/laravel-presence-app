<?php

namespace Tests\Livewire\Cms\PartitionA\Categories;

use App\Http\Livewire\Cms\Categories\CategoriesIndex;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Promo;
use Illuminate\Foundation\Testing\Concerns\InteractsWithSession;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\CmsTests;
use Tests\TestCase;

class CategoriesIndexTest extends TestCase
{
    use CmsTests;
    use DatabaseMigrations;
    use InteractsWithSession;

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

        $this->session([]);

        $this->seed(['PermissionSeeder', 'RoleSeeder']);

        $this->admin = Admin::factory()->create()->assignRole('super-administrator');

        $this->actingAs($this->admin, config('cms.guard'));

        Category::factory(5)->create();
    }

    /** @test */
    public function datatable_component_is_accessible()
    {
        Livewire::test('cms.categories.categories-index')
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_jump_to_a_specific_page()
    {
        Livewire::test('cms.categories.categories-index')
            ->set('perPage', 1)
            ->call('refresh')
            ->call('goTo', 2)
            ->assertSet('currentPage', 2);
    }

    /** @test */
    public function it_can_load_its_state_from_the_session_store()
    {
        $data = [
            'perPage'       => 1,
            'sortColumn'    => 'created_at',
            'sortDirection' => 'desc',
        ];
        session()->put(CategoriesIndex::class, $data);

        Livewire::test('cms.categories.categories-index')
            ->assertSet('perPage', 1)
            ->assertSet('sortColumn', 'created_at')
            ->assertSet('sortDirection', 'desc');
    }

    /** @test */
    public function it_can_set_default_category_for_promo_on_category_deletion()
    {
        $promo = Promo::factory()->create();
        $promo->categories()->attach(1);

        Livewire::test('cms.categories.categories-index')
            ->call('cascadeCategory', 1);

        $defaultCategoryId = Category::getDefaultCategoryId();
        $this->assertTrue(Category::count() === $defaultCategoryId - 1);
        $this->assertDatabaseHas('category_translations', [
            'category_id' => $defaultCategoryId,
            'locale'      => 'en',
            'name'        => Category::DEFAULT_NAME_EN,
        ]);
        $this->assertDatabaseHas('category_translations', [
            'category_id' => $defaultCategoryId,
            'locale'      => 'id',
            'name'        => Category::DEFAULT_NAME_ID,
        ]);
        $this->assertDatabaseHas('category_promo', [
            'promo_id'      => $promo->id,
            'category_id'   => $defaultCategoryId,
        ]);
    }

    /** @test */
    public function it_can_set_default_category_for_promo_on_selected_categories_deletion()
    {
        $promos = Promo::factory(3)->create();

        $test = Livewire::test('cms.categories.categories-index');
        for ($i = 1; $i <= $promos->count(); $i++) {
            $promos[$i - 1]->categories()->attach($i);
            $test->set('selectedRows.'.$i, true);
        }
        $test->call('cascadeSelectedCategory');

        $defaultCategoryId = Category::getDefaultCategoryId();
        $this->assertTrue(Category::count() === $defaultCategoryId - 3);
        $this->assertDatabaseHas('category_translations', [
            'category_id' => $defaultCategoryId,
            'locale'      => 'en',
            'name'        => Category::DEFAULT_NAME_EN,
        ]);
        $this->assertDatabaseHas('category_translations', [
            'category_id' => $defaultCategoryId,
            'locale'      => 'id',
            'name'        => Category::DEFAULT_NAME_ID,
        ]);
        foreach ($promos as $promo) {
            $this->assertDatabaseHas('category_promo', [
                'promo_id'      => $promo->id,
                'category_id'   => $defaultCategoryId,
            ]);
        }
    }
}
