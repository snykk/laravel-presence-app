<?php

namespace App\Models\Concerns;

use App\Models\Cta;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasCta
{
    /**
     * Model has morph many to ctas.
     *
     * @return MorphMany
     */
    public function ctas(): MorphMany
    {
        return $this->morphMany(Cta::class, 'ctable')->joinTranslation();
    }
}
