<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MoveLocationTranslationsName extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'location:move-location-translations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move location_translations name to to title field of locations to pivot table';

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
     * Get string argument.
     *
     * @param string $key
     * @param string $default
     *
     * @return string
     */
    protected function getStringArgument(string $key, string $default): string
    {
        return is_string($this->argument($key)) ? $this->argument($key) : $default;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $locationTranslations = DB::table('location_translations')
                        ->where('locale', 'en')
                        ->get();

        foreach ($locationTranslations as $locationTranslation) {
            DB::table('locations')
                ->where('id', $locationTranslation->location_id)
                ->update([
                    'title'   => $locationTranslation->name,
                ]);
        }

        $this->line('<info>Location translations name has been moved to locations table.</info>');
    }
}
