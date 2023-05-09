<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait BannerRankScope
{
    /**
     * Scope to get all banners that have rank higher than 0.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeRankIsntZero(Builder $query): Builder
    {
        return $query->where('rank', '>', 0);
    }
}
