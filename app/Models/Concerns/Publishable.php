<?php

namespace App\Models\Concerns;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait Publishable
{
    /**
     * Scope to add condition `published_at` is not null. (Published model).
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|bool                           $published
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished(Builder $query, $published = 'true')
    {
        if ($published === true || $published === 'true') {
            return $query->whereNotNull('published_at');
        }

        return $query->whereNull('published_at');
    }

    /**
     * Scope to add condition `published_at` is null. (Unpublished Model).
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnpublished(Builder $query)
    {
        return $query->whereNull('published_at');
    }

    /**
     * Set `published_at` attributes given true or false value.
     * If true `published_at` will be set to current datetime, null otherwise.
     *
     * @param bool|string $value
     *
     * @return void
     */
    public function setPublishedAttribute($value)
    {
        if ($value === true || $value === 'true') {
            if (!$this->published) {
                $this->published_at = new Carbon();
            }

            return;
        }

        $this->published_at = null;
    }

    /**
     * Get published flag.
     *
     * @return mixed
     */
    public function getPublishedAttribute()
    {
        return $this->published_at == true;
    }

    /**
     * Get published name.
     *
     * @return string
     */
    public function getPublishedNameAttribute()
    {
        return $this->published_at ? 'Yes' : 'No';
    }

    /**
     * Scope order published.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $order
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderPublished($query, $order = 'ASC')
    {
        return $query->orderBy('published_at', $order);
    }
}
