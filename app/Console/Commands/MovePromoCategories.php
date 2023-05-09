<?php

namespace App\Console\Commands;

use App\Models\Promo;
use DB;
use Illuminate\Console\Command;

class MovePromoCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promo:move-category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move category_id from promos table to pivot table.';

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
        try {
            Promo::get(['id', 'category_id'])->each(function ($promo) {
                DB::table('category_promo')->insertOrIgnore([
                    'promo_id'    => $promo->id,
                    'category_id' => $promo->category_id, // @phpstan-ignore-line
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            });

            $this->line('<info>Promo category_id has been moved to pivot table.</info>');
        } catch (\Exception $e) {
            if ($e instanceof \PDOException) {
                $this->line('<error>Promo category_id column has been deleted.</error>');

                return;
            }
            \Log::debug($e);
            dump($e->getMessage()); // @phpstan-ignore-line
        }
    }
}
