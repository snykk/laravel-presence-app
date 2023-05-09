<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Promo;
use Illuminate\Console\Command;

class ApplyDefaultCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'default:category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Apply default category to promos without category';

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
        $defaultCategoryId = Category::getDefaultCategoryId();
        $promos = Promo::whereDoesntHave('categories')->get();
        foreach ($promos as $promo) {
            $promo->categories()->attach($defaultCategoryId);
        }
        $this->line('<info>Default category has been applied to promos without category.</info>');
    }
}
