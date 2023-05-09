<?php

namespace Tests\Unit\App\Support;

use App\Models\SeoMeta;
use App\Support\MediaUrlGenerator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGeneratorFactory;
use Tests\TestCase;

class MediaUrlGeneratorTest extends TestCase
{
    use DatabaseMigrations;

    protected SeoMeta $seoMeta;
    protected Media $media;
    protected MediaUrlGenerator $generator;
    protected mixed $originalFilesystem;

    /**
     * Setup the test environment.
     *
     * return void
     */
    public function setUp(): void
    {
        parent::setUp();

        Config::set('media-library.disk_name', 's3');
        Config::set('media-library.url_generator', MediaUrlGenerator::class);
        Config::set('filesystems.disks.s3.root', '/public/storage');
        Config::set('filesystems.disks.s3.url', 'https://assets.gopay.co.id');
        Config::set('cms.aws_url_replace_pattern', '/public/');
        Config::set('cms.aws_url_replace_with', '/');

        $this->originalFilesystem = Storage::disk(config('media-library.disk_name'));

        Storage::fake(config('media-library.disk_name'));

        $this->seoMeta = SeoMeta::factory()->create();
        $this->seoMeta->addMediaFromDisk('image.jpg', 'dummies')
            ->preservingOriginal()
            ->toMediaCollection('seo_image')
            ->getGeneratedConversions();

        $this->media = $this->seoMeta->getFirstMedia('seo_image');

        $this->generator = app(MediaUrlGenerator::class);

        $pathGenerator = PathGeneratorFactory::create();

        $this->generator->setMedia($this->media)
            ->setPathGenerator($pathGenerator);

        Storage::set(config('media-library.disk_name'), $this->originalFilesystem);
    }

    /** @test */
    public function it_can_return_the_parsed_url_correctly()
    {
        $expected = 'https://assets.gopay.co.id/storage/1/image.jpg';

        self::assertEquals($expected, $this->generator->getUrl());
    }

    /** @test */
    public function it_can_return_the_parsed_base_media_directory_url_correctly()
    {
        $expected = 'https://assets.gopay.co.id/storage/';

        self::assertEquals($expected, $this->generator->getBaseMediaDirectoryUrl());
    }

    /** @test */
    public function it_can_return_the_parsed_media_conversion_url_correctly()
    {
        $this->seoMeta->refresh();

        $expected1 = 'https://assets.gopay.co.id/storage/1/conversions/image-seo_image_large.jpg';
        $expected2 = 'https://assets.gopay.co.id/storage/1/conversions/image-seo_image_small.jpg';

        self::assertEquals($expected1, $this->seoMeta->getFirstMediaUrl('seo_image', 'seo_image_large'));
        self::assertEquals($expected2, $this->seoMeta->getFirstMediaUrl('seo_image', 'seo_image_small'));
    }
}
