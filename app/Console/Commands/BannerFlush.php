<?php

namespace App\Console\Commands;

use App\Models\Banner;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class BannerFlush extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'banner:flush';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete banners that are related to deleted promos or banners that doens\'t have any media.';

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
        Banner::whereDoesntHave('media')->orWhere(function (Builder $query) {
            $query->where('promo_id', '!=', null)->whereDoesntHave('promo');
        })->delete();

        $this->line('<info>Unused banners have been deleted.</info>');
    }
}
