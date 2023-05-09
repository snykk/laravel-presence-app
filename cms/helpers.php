<?php

use App\Models\Admin;

/**
 * @SuppressWarnings(PHPMD.MissingImport)
 */
if (!function_exists('cms_admin')) {
    /**
     * Get the current authenticated cms admin.
     *
     * @throws \ErrorException
     *
     * @return Admin
     */
    function cms_admin(): Admin
    {
        $admin = auth()->guard(config('cms.guard'))->user();

        if (!($admin instanceof Admin)) {
            throw new \ErrorException('The logged in user is not an instance of CMS Admin model.');
        }

        return $admin;
    }
}

/**
 * @SuppressWarnings(PHPMD.MissingImport)
 */
if (!function_exists('getExtension')) {
    /**
     * Get the extension from a file path.
     *
     * @return string
     */
    function getExtension(string $path): string
    {
        $defaultExtension = '.jpg';

        if (!isset($path) || $path === '') {
            return $defaultExtension;
        }
        $index = strrpos($path, '.');

        return ($index > 0) ? substr($path, $index) : $defaultExtension;
    }
}

/**
 * @SuppressWarnings(PHPMD.MissingImport)
 */
if (!function_exists('hasS3')) {
    /**
     * Check whether S3 credentials is supplied or not.
     *
     * @return bool
     */
    function hasS3(): bool
    {
        return config('media-library.disk_name') == 's3';
    }
}
