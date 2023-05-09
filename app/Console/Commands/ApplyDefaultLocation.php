<?php

namespace App\Console\Commands;

use App\Models\Location;
use App\Models\Promo;
use Illuminate\Console\Command;

class ApplyDefaultLocation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'default:location';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Apply default location to promos without location';

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
        $defaultLocationId = Location::getDefaultLocationId();
        $promos = Promo::whereDoesntHave('locations')->get();
        $promos->each(function ($promo) use ($defaultLocationId) {
            $promo->locations()->attach($defaultLocationId);
        });
        $this->line('<info>Default location has been applied to promos without location.</info>');
    }
}
