<?php

namespace App\Console\Commands;

use App\Models\HomeBanner;
use Illuminate\Console\Command;

class MoveHomeBannerDevices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'home-banner:move-devices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adjust current home banner media for multiple devices usage.';

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
        $homeBanners = HomeBanner::with('media')->get();
        $locales = HomeBanner::getLocales();
        $devices = HomeBanner::IMAGE_DEVICES;

        foreach ($homeBanners as $homeBanner) {
            foreach ($locales as $locale) {
                $oldCollectionName = HomeBanner::IMAGE_COLLECTION.'-'.$locale;

                $mediaItem = $homeBanner->getMedia($oldCollectionName)->first();
                if ($mediaItem === null) {
                    continue;
                }
                foreach ($devices as $device) {
                    $newCollectionName = HomeBanner::getFormattedColectionName($device, $locale);
                    $mediaItem->copy($homeBanner, $newCollectionName);
                }
                $mediaItem->delete();
            }
        }

        $this->line('<info>Existing home banners have been adjusted to support device type.</info>');
    }
}
