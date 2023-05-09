<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class VarnishFlush extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'varnish:flush';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle()
    {
        if (config('env.VARNISH_ENABLED')) {
            $hosts = explode(',', config('env.APP_HOST'));

            foreach ($hosts as $host) {
                \Varnishable::flush(trim($host));
            }
        }
    }
}
