<?php

namespace App\Models\Concerns;

use App\Models\Promo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasPromo
{
    /**
     * Model relationship definition.
     * Category belongs to many Promos.
     *
     * @return BelongsToMany
     */
    public function promos(): BelongsToMany
    {
        return $this->belongsToMany(Promo::class);
    }

    /**
     * Update has promo value.
     *
     * @return void
     */
    public static function updateHasPromo(): void
    {
        $changedRow = [[], []];
        $models = self::with('promos:id')
            ->with('promos.brand:id')
            ->with('promos.locations:id')
            ->with('promos.categories:id')
            ->get(['id', 'has_promo']);
        foreach ($models as $model) {
            $newValue = $model->promos()->notExpired()->completeData()->exists();
            if ($model->has_promo == $newValue) {
                continue;
            }
            $changedRow[$newValue][] = $model->id;
        }
        foreach ([0, 1] as $value) {
            if (empty($changedRow[$value])) {
                continue;
            }
            self::whereIn('id', $changedRow[$value])
                ->update(['has_promo' => $value]);
        }
    }

    /**
     * Scope to get location that has a relation to a minimum of 1 promo.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeHaveNotExpiredPromo(Builder $query): Builder
    {
        return $query->whereHas('promos', function ($q) {
            $q->notExpired()->completeData();
        });
    }
}
