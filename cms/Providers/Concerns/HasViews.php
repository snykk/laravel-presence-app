<?php

namespace Cms\Providers\Concerns;

use Cms\Blade\MultilingualForm;
use Illuminate\Support\Facades\Blade;

trait HasViews
{
    /**
     * Register custom blade directives.
     */
    protected function registerBladeDirectives(): void
    {
        Blade::directive('multilingual', static function ($expression) {
            return (new MultilingualForm($expression))->getOpeningElements();
        });

        Blade::directive('endmultilingual', static function () {
            return (new MultilingualForm())->getEndingElements();
        });

        Blade::directive('multiSeoTitleCharCount', static function () {
            return (new MultilingualForm())->getMultiCharacterCountSeoTitleElements();
        });

        Blade::directive('multiSeoDescCharCount', static function () {
            return (new MultilingualForm())->getMultiCharacterCountSeoDescElements();
        });

        Blade::directive('multiSeoKeywordCharCount', static function () {
            return (new MultilingualForm())->getMultiCharacterCountSeoKeywordElements();
        });
    }

    /**
     * Register the package's views.
     *
     * @return void
     */
    protected function registerViews(): void
    {
        $viewPath = realpath(base_path('resources/views/vendor/cms'));

        if ($viewPath !== false) {
            $this->loadViewsFrom($viewPath, 'cms');
        }
    }
}
