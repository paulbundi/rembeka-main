<?php

namespace App\Observers;

use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class MediaObserver
{
    public function deleting(Media $media)
    {
        Storage::disk($media->disk)->delete($media->path);
    }
}
