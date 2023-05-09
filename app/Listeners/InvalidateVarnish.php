<?php

namespace App\Listeners;

use RichanFongdasen\Varnishable\Events\ModelHasUpdated;

class InvalidateVarnish
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param \RichanFongdasen\Varnishable\Events\ModelHasUpdated $event
     *
     * @SuppressWarnings("unused")
     *
     * @return void
     */
    public function handle(ModelHasUpdated $event)
    {
        if (!(bool) config('env.VARNISH_ENABLED')) {
            return;
        }

//        $model = $event->model();
//        $class = get_class($model);
//        $patterns = config('varnish-invalidate-pattern')[$class] ?? false;
//
//        if ($patterns) {
//            $patterns = !is_array($patterns) ? [$patterns] : $patterns;
//
//            \Varnishable::banByPatterns(config('env.APP_HOST'), $patterns);
//
//            return;
//        }

        $hosts = explode(',', config('env.APP_HOST'));

        foreach ($hosts as $host) {
            \Varnishable::flush(trim($host));
        }
    }
}
