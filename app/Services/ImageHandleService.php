<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageHandleService
{
    public function uploadImage($image, $path, $disk = 's3')
    {

        $filePath = $image->store($path, $disk);

        Storage::disk($disk)->setVisibility($filePath, 'public');

        return Storage::disk($disk)->url($filePath);
    }

    public function deleteImage($image, $path, $disk = 's3')
    {
        Storage::disk($disk)->delete($path . '/' . $image);
    }

    public function getImageUrl($image, $path, $disk = 's3')
    {
        return Storage::disk($disk)->url($path . '/' . $image);
    }
}
