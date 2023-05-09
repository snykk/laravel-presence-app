<?php

namespace App\Support;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator;

class MediaUrlGenerator extends DefaultUrlGenerator
{
    /**
     * Override the original getUrl method.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->parseUrl(parent::getUrl());
    }

    /**
     * Override the original getBaseMediaDirectoryUrl method.
     *
     * @return string
     */
    public function getBaseMediaDirectoryUrl()
    {
        return Str::finish($this->parseUrl(parent::getBaseMediaDirectoryUrl()), '/');
    }

    /**
     * Parse the AWS URL to be a correct one,
     * by stripping invalid path.
     *
     * @param string $url
     *
     * @return string
     */
    protected function parseUrl(string $url): string
    {
        $search = config('cms.aws_url_replace_pattern');
        $replace = config('cms.aws_url_replace_with');

        if (($search === null) || ($search === '')) {
            return $url;
        }

        return str_replace($search, $replace, $url);
    }

    /**
     * Parse the AWS URL to be a correct one,
     * by stripping invalid path.
     *
     * @param string $url
     *
     * @return string
     */
    public function parseFromUrl(string $url): string
    {
        return $this->parseUrl($url);
    }

    /**
     * Parse the AWS URL to be a correct one,
     * by stripping invalid path.
     *
     * @return string
     */
    public function getResponsiveImagesDirectoryUrl(): string
    {
        return Str::finish($this->parseUrl(parent::getResponsiveImagesDirectoryUrl()), '/');
    }
}
