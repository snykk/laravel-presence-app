<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class MoveArticleSlug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'article:move-slug';

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
        $articleTranslations = DB::table('article_translations')
            ->where('locale', 'id')
            ->get();

        foreach ($articleTranslations as $articleTranslation) {
            DB::table('articles')
                ->where('id', $articleTranslation->article_id)
                ->update([
                    'slug'      => $articleTranslation->slug,
                ]);
        }

        $this->line('<info>Article translations slug has been moved to articles table.</info>');

        return 0;
    }
}
