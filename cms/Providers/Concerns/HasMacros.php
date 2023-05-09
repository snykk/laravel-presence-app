<?php

namespace Cms\Providers\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use RichanFongdasen\I18n\Contracts\TranslatableModel;

trait HasMacros
{
    /**
     * Register whereLike macro to the Eloquent Builder.
     *
     * @return void
     */
    protected function registerWhereLikeMacroToBuilder(): void
    {
        Builder::macro('whereLike', function ($attributes, string $searchTerm) {
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach (Arr::wrap($attributes) as $attribute) {
                    $query->when(
                        Str::contains($attribute, '.') && substr_count($attribute, '.') == 1,
                        function (Builder $query) use ($attribute, $searchTerm) {
                            [$relationName, $relationAttribute] = explode('.', $attribute);

                            $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $searchTerm) {
                                $operator = (config('database.default') === 'pgsql') ? 'ILIKE' : 'LIKE';
                                $query->where($relationAttribute, $operator, "%{$searchTerm}%");
                            });

                            return $query;
                        }
                    );
                    $query->when(
                        Str::contains($attribute, '.') && substr_count($attribute, '.') == 2,
                        function (Builder $query) use ($attribute, $searchTerm) {
                            [$firstRelation, $secondRelation, $relationAttribute] = explode('.', $attribute);

                            $query->orWhereHas($firstRelation, function (Builder $query) use ($secondRelation, $relationAttribute, $searchTerm) {
                                $query->whereHas($secondRelation, function (Builder $query) use ($relationAttribute, $searchTerm) {
                                    $operator = (config('database.default') === 'pgsql') ? 'ILIKE' : 'LIKE';
                                    $query->where($relationAttribute, $operator, "%{$searchTerm}%");
                                });
                            });

                            return $query;
                        },
                    );

                    $query->when(
                        !Str::contains($attribute, '.'),
                        function (Builder $query) use ($attribute, $searchTerm) {
                            $operator = (config('database.default') === 'pgsql') ? 'ILIKE' : 'LIKE';

                            $model = $query->getModel();
                            $tableName = $model->getTable();
                            /** @phpstan-ignore-next-line */
                            if ($model instanceof TranslatableModel && in_array($attribute, $model->getTranslatableAttributes())) {
                                $tableName = $model->getTranslationTable();
                            }

                            $attribute = "${tableName}.${attribute}";

                            $query->orWhere($attribute, $operator, "%{$searchTerm}%");

                            return $query;
                        }
                    );
                }
            });

            return $this;
        });
    }
}
