<?php

namespace App\Providers;

use App\Models\TopupAnchor;
use App\Models\TopupVendor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function boot()
    {
        Validator::extend('valid_ctable_id', function ($attribute, $value, $parameters, $validator) {
            $model = $validator->getData()['cta']['ctable_type'];
            if (!is_subclass_of($model, Model::class)) {
                return false;
            }

            $row = $model::find($value);

            return $row !== null && $row->count() !== 0;
        });

        $this->methodableId();
        $this->fileName();
        $this->duplicateMethodable();
    }

    /**
     * Check if methodable id exists.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    private function methodableId(): void
    {
        $messageMethodableId = 'Anchor/Vendor is not valid!';
        Validator::extend('valid_methodable_id', function ($attribute, $value, $parameters, $validator) {
            $model = $validator->getData()['topupMethod']['methodable_type'];
            if (!is_subclass_of($model, Model::class)) {
                return false;
            }

            $row = $model::find($value);

            return $row !== null && $row->count() !== 0;
        }, $messageMethodableId);
    }

    /**
     * Check if methodable id exists.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    private function fileName(): void
    {
        $messageMethodableId = 'Forbidden file name!';
        Validator::extend('file_name', function ($attribute, $value, $parameters, $validator) {
            $forbiddenChars = ['<', '>', ':', '"', '/', '\\', '|', '?', '*', '+', "'", '%'];

            if ($value !== null) {
                foreach ($value as $file) {
                    foreach ($forbiddenChars as $char) {
                        if (str_contains($file['fileName'], $char)) {
                            return false;
                        }
                    }
                }
            }

            return true;
        }, $messageMethodableId);
    }

    /**
     * Check if duplicate methodable exists.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    private function duplicateMethodable(): void
    {
        $messageDuplicate = 'Please unpublish methods in related anchor if you try to make method for vendor or unpublish methods in related vendors if otherwise!';
        Validator::extend('no_duplicate_in_anchor_and_vendor', function ($attribute, $value, $parameters, $validator) {
            $model = $validator->getData()['topupMethod']['methodable_type'];
            $model = $model == TopupAnchor::class ? TopupVendor::class : TopupAnchor::class;

            if ($model == TopupAnchor::class) {
                $id = $validator->getData()['topupMethod']['methodable_id'];
                $vendor = TopupVendor::find($id);
                $anchor = optional($vendor)->topupAnchor;
                $topupMethods = optional($anchor)->topupMethods;

                if ($topupMethods !== null) {
                    foreach ($topupMethods as $topupMethod) {
                        if ($topupMethod->published_at !== null) {
                            return false;
                        }
                    }
                }
            }

            if ($model == TopupVendor::class) {
                $id = $validator->getData()['topupMethod']['methodable_id'];
                $anchor = TopupAnchor::find($id);
                $vendors = optional($anchor)->topupVendors;

                if ($vendors !== null) {
                    foreach ($vendors as $vendor) {
                        $topupMethods = optional($vendor)->topupMethods;

                        foreach ($topupMethods as $topupMethod) {
                            if ($topupMethod->published_at !== null) {
                                return false;
                            }
                        }
                    }
                }
            }

            return true;
        }, $messageDuplicate);
    }
}
