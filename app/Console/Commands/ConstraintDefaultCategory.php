<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;

class ConstraintDefaultCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:constraint-default';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove other categories when promo is related to default category.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $defaultCategory = Category::where('id', Category::getDefaultCategoryId())->first();
        $promos = $defaultCategory?->promos;
        foreach ($promos as $promo) {
            $promo->categories()->sync(Category::getDefaultCategoryId());
        }
    }
}
