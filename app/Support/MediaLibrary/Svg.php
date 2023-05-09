<?php

namespace App\Support\MediaLibrary;

use Imagick;
use ImagickPixel;
use Spatie\MediaLibrary\Conversions\Conversion;
use Spatie\MediaLibrary\Conversions\ImageGenerators\Svg as SvgConvert;

class Svg extends SvgConvert
{
    /**
     * Convert Image.
     *
     * @param string          $file
     * @param Conversion|null $conversion
     *
     * @SuppressWarnings("unused")
     *
     * @return string
     */
    public function convert(string $file, Conversion $conversion = null): string
    {
        $imageFile = pathinfo($file, PATHINFO_DIRNAME).'/'.pathinfo($file, PATHINFO_FILENAME).'.png';

        $image = new Imagick();
        $image->readImage($file);
        $image->setBackgroundColor(new ImagickPixel('none'));
        $image->setImageFormat('png');

        file_put_contents($imageFile, $image);

        return $imageFile;
    }
}
