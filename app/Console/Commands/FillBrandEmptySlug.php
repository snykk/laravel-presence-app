<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;
use Str;

class FillBrandEmptySlug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'brand:fill-empty-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill the empty brand slug columns';

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
        $brandEmptySlugs = DB::table('brands')
            ->where('slug', '')
            ->get();

        foreach ($brandEmptySlugs as $brandEmptySlug) {
            DB::table('brands')
                ->where('id', $brandEmptySlug->id)
                ->update([
                    'slug' => Str::slug($brandEmptySlug->title),
                ]);
        }

        $this->line('<info>Brand slug has been filled.</info>');

        return 0;
    }
}
