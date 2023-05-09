<?php

namespace App\Models\Concerns;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait DateScope
{
    /**
     * Get start date.
     *
     * @return string
     */
    abstract protected function getStartDateColumnAttribute(): string;

    /**
     * Get end date.
     *
     * @return string
     */
    abstract protected function getEndDateColumnAttribute(): string;

    /**
     * Scope date after the inputted date (inclusive).
     *
     * @param Builder $query
     * @param string  $date
     *
     * @return Builder
     */
    public function scopeDateFrom(Builder $query, string $date): Builder
    {
        return $query->where($this->start_date_column, '>=', Carbon::parse($date));
    }

    /**
     * Scope date before the inputted date (inclusive).
     *
     * @param Builder $query
     * @param string  $date
     *
     * @return Builder
     */
    public function scopeDateUntil(Builder $query, string $date): Builder
    {
        return $query->where($this->end_date_column, '<=', Carbon::parse($date));
    }

    /**
     * Scope date between the range of inputted date (inclusive).
     *
     * @param Builder $query
     * @param string  $startDate
     * @param string  $endDate
     *
     * @return Builder
     */
    public function scopeDateBetween(Builder $query, string $startDate, string $endDate): Builder
    {
        return $query
            ->where($this->start_date_column, '<=', Carbon::parse($endDate))
            ->where($this->end_date_column, '>=', Carbon::parse($startDate));
    }

    /**
     * Accessor for start date.
     *
     * @return string
     */
    public function getStartDateAttribute()
    {
        return Carbon::parse($this->attributes[$this->start_date_column])->format('Y-m-d');
    }

    /**
     * Accessor for end date.
     *
     * @return string
     */
    public function getEndDateAttribute()
    {
        return Carbon::parse($this->attributes[$this->end_date_column])->format('Y-m-d');
    }

    /**
     * Scope to get all active promo.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where($this->start_date_column, '<=', today())
            ->where($this->end_date_column, '>=', today());
    }

    /**
     * Scope to get promo based on active or not active.
     *
     * @param Builder $query
     * @param bool    $isActive
     *
     * @return Builder
     */
    public function scopeIsActive(Builder $query, bool $isActive): Builder
    {
        if ($isActive) {
            return $this->active();
        }

        return $query->where($this->start_date_column, '>', today())
            ->orWhere($this->end_date_column, '<', today());
    }

    /**
     * Check if model is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->start_date <= today() && $this->end_date >= today();
    }

    /**
     * Check if model is active.
     *
     * @return bool
     *
     * @SuppressWarnings(PHPMD)
     */
    public function getIsActiveAttribute(): bool
    {
        return $this->isActive();
    }

    /**
     * Scope to get all promo that haven't expired.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeNotExpired(Builder $query): Builder
    {
        return $query->where($this->end_date_column, '>=', today());
    }
}
