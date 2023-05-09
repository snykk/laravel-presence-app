<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;

class CreateNewSetting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setting:add {key} {value=default}';

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
     * @return void
     */
    public function handle()
    {
        $value = $this->getStringArgument('value', 'default');

        $setting = Setting::create([
            'key'      => $this->argument('key'),
            'value'    => $value,
            'type'     => 'textarea',
        ]);

        $this->line("<info>Setting '".$setting->getAttribute('key')."' has been created.</info>");
    }
}
