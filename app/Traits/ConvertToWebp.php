<?php

namespace App\Traits;

use Intervention\Image\Image;

trait ConvertToWebp
{
    public function convertToWebp($image, $path)
    {
        $filename = uniqid() . '.webp';
        $fullPath = storage_path('app/public/' . $path . '/' . $filename);
        
        $sourceImage = imagecreatefromstring(file_get_contents($image));
        imagewebp($sourceImage, $fullPath, 80);
        imagedestroy($sourceImage);
        
        return $path . '/' . $filename;
    }
}
