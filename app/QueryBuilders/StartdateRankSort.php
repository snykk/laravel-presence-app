<?php

namespace App\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class StartdateRankSort implements Sort
{
    /**
     * @param Builder $query
     * @param bool    $descending
     * @param string  $property
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameters)
     */
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $query
            ->orderBy('rank', 'desc')
            ->orderBy('start_date', 'desc');
    }
}
