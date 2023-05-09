<?php

namespace App\Console\Commands;

use App\Models\Banner;
use DB;
use Illuminate\Console\Command;

class FillBannerTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'banner:fill-translations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill translations for banner that has no standlone_url.';

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
        $banners = Banner::with('media')->validBanner()->get();
        foreach ($banners as $banner) {
            DB::table('banner_translations')->insertOrIgnore([
                ['banner_id' => $banner->id, 'locale' => 'en', 'standalone_url' => null],
                ['banner_id' => $banner->id, 'locale' => 'id', 'standalone_url' => null],
            ]);
        }
        $this->line('<info>Banner translations table has been filled.</info>');
    }
}
