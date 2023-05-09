<?php

namespace App\Models\Concerns;

trait RouteSluggable
{
    // protected $routeKey = 'slug';

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return $this->routeKey ?? 'slug';
    }
}
