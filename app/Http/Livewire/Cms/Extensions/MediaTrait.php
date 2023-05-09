<?php

namespace App\Http\Livewire\Cms\Extensions;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait MediaTrait
{
    /**
     * @param int $mediaId
     *
     * @return mixed
     */
    public function mediaRemove($mediaId)
    {
        $media = Media::find($mediaId);
        if ($media) {
            $media->delete(); //@phpstan-ignore-line
            session()->flash('alertType', 'success');
            session()->flash('alertMessage', 'Media ('.$mediaId.') has been deleted.');
            $this->edit();
        }
    }
}
