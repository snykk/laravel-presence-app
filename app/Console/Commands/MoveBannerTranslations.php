<?php

namespace App\Console\Commands;

use App\Models\Banner;
use DB;
use Illuminate\Console\Command;

class MoveBannerTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'banner:move-banner-translations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move standalone url and banner images to banner translations.';

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
        $banners = Banner::with('media')->get();
        $oldCollectionNames = Banner::RAW_IMAGE_COLLECTIONS;

        foreach ($banners as $banner) {
            DB::table('banner_translations')->insertOrIgnore([
                ['banner_id' => $banner->id, 'locale' => 'en', 'standalone_url' => $banner->standalone_url],
                ['banner_id' => $banner->id, 'locale' => 'id', 'standalone_url' => $banner->standalone_url],
            ]);

            foreach ($oldCollectionNames as $oldCollectionName) {
                $mediaItem = $banner->getMedia($oldCollectionName)->first();
                if ($mediaItem === null) {
                    continue;
                }

                $mediaItem->copy($banner, $oldCollectionName.'-en');
                $mediaItem->copy($banner, $oldCollectionName.'-id');
                $mediaItem->delete();
            }
        }

        $this->line('<info>Banners have been migrated to translations table.</info>');
    }
}
