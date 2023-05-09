<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class MoveBrandTranslationsName extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'brand:move-brand-translations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move brand_translations name to to title field of brands table';

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
     * @return mixed
     */
    public function handle()
    {
        $brandTranslations = DB::table('brand_translations')
            ->where('locale', 'en')
            ->get();

        foreach ($brandTranslations as $brandTranslation) {
            DB::table('brands')
                ->where('id', $brandTranslation->brand_id)
                ->update([
                    'title'   => $brandTranslation->name,
                ]);
        }

        $this->line('<info>Location translations name has been moved to locations table.</info>');
    }
}
