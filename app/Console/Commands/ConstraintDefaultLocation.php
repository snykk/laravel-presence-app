<?php

namespace App\Console\Commands;

use App\Models\Location;
use Illuminate\Console\Command;

class ConstraintDefaultLocation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'location:constraint-default';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove other locations when promo is related to default location.';

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
        $defaultLocation = Location::where('id', Location::getDefaultLocationId())->first();
        $promos = $defaultLocation?->promos;
        foreach ($promos as $promo) {
            $promo->locations()->sync(Location::getDefaultLocationId());
        }
    }
}
