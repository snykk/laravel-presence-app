<?php

namespace App\Http\Livewire\Cms\Extensions;

use Cms\Livewire\DatatableColumn;

trait PublishedDateColumn
{
    /**
     * @return DatatableColumn
     */
    public function publishedDateColumnFormat()
    {
        return DatatableColumn::make('published_at')
            ->renderWith(function ($model) {
                return $model->published ? 'Yes' : 'No';
            })->setTitle('Published');
    }
}
