<?php

namespace Cms\Livewire\Concerns;

use Spatie\MediaLibrary\Conversions\Conversion;
use Spatie\MediaLibrary\Support\FileNamer\FileNamer;
use Str;

class CustomFileNamer extends FileNamer
{
    public function originalFileName(string $fileName): string
    {
        return Str::slug(pathinfo($fileName, PATHINFO_FILENAME));
    }

    public function conversionFileName(string $fileName, Conversion $conversion): string
    {
        $strippedFileName = pathinfo($fileName, PATHINFO_FILENAME);

        return Str::slug("{$strippedFileName}-{$conversion->getName()}");
    }

    public function responsiveFileName(string $fileName): string
    {
        return Str::slug(pathinfo($fileName, PATHINFO_FILENAME));
    }
}
