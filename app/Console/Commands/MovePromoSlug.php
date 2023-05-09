<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class MovePromoSlug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promo:move-slug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move slug from translations to articles table.';

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
        $promoTranslations = DB::table('promo_translations')
            ->where('locale', 'id')
            ->get();

        foreach ($promoTranslations as $promoTranslation) {
            DB::table('promos')
                ->where('id', $promoTranslation->promo_id)
                ->update([
                    'slug' => $promoTranslation->slug,
                ]);
        }

        $this->line('<info>Promo translations slug has been moved to promos table.</info>');

        return 0;
    }
}
