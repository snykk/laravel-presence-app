<?php

namespace Cms\Livewire\Concerns;

use Illuminate\Support\Collection;

trait OptionsGetter
{
    /**
     * @param Collection $all
     * @param bool       $hasEmptyValue
     * @param string     $column
     *
     * @return array|string[]
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function getOptions(Collection $all, bool $hasEmptyValue = false, string $column = 'name'): array
    {
        $options = ($hasEmptyValue) ? [0 => 'Not Selected'] : [];

        // In id-name pair
        foreach ($all as $a) {
            $options[$a->id] = $a->$column;
        }

        return $options;
    }
}
