<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class MoveStaticPageSlug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'staticPage:move-slug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move slug from translations to static pages table';

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
        $spTranslations = DB::table('static_page_translations')
            ->where('locale', 'id')
            ->get();

        foreach ($spTranslations as $spTranslation) {
            DB::table('static_pages')
                ->where('id', $spTranslation->static_page_id)
                ->update([
                    'slug' => $spTranslation->slug,
                ]);
        }

        $this->line('<info>Static page translations slug has been moved to static pages table.</info>');

        return 0;
    }
}
