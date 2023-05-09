<?php

namespace App\Http\Controllers;

use Facades\App\Support\MediaUrlGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TinyMceImageController extends Controller
{
    /**
     * Handle store image action on tinymce.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // @phpstan-ignore-next-line
        $path = '/'.$request->file('file')->store('tinymce', config('media-library.disk_name'));
        $path = (hasS3()) ?
            MediaUrlGenerator::parseFromUrl(config('filesystems.disks.s3.root').$path) :
            '/storage'.$path;

        return response()->json(['location' => $path]);
    }
}
