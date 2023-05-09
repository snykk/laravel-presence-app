<?php

namespace App\Console\Commands;

use App\Models\Promo;
use Illuminate\Console\Command;

class FixPromoSlug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promo:fix-promo-slug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix the hreflang implementation slug error.';

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
     * @return int
     */
    public function handle()
    {
        $promos = Promo::where('slug', 'LIKE', '{"%')->with('translations')->get();

        foreach ($promos as $promo) {
            $promo->update([
                //@phpstan-ignore-next-line
                'slug' => $promo->translations->where('locale', 'id')->first()->slug,
            ]);
        }

        $this->line('<info>Promo slug hreflang error is fixed.</info>');

        return 0;
    }
}
