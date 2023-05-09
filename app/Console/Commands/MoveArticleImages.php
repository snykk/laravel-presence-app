<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;

class MoveArticleImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'article:move-article-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy single language article image to multi language image.';

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
        $articles = Article::all();

        foreach ($articles as $article) {
            $mediaItem = $article->getMedia(Article::IMAGE_COLLECTION)->first();
            if ($mediaItem !== null) {
                $mediaItem->copy($article, Article::IMAGE_COLLECTION.'-en');
                $mediaItem->copy($article, Article::IMAGE_COLLECTION.'-id');
            }
        }

        $this->line('<info>Article images have been migrated.</info>');
    }
}
