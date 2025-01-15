<?php

namespace App\Traits;

use Intervention\Image\Image;

trait ConvertToWebp
{
    public function convertToWebp($image, $path)
    {
        $filename = uniqid() . '.webp';
        $directory = storage_path('app/public/' . $path);
        
        // Create directory if it doesn't exist
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        
        $fullPath = $directory . '/' . $filename;
        
        $sourceImage = imagecreatefromstring(file_get_contents($image));
        imagewebp($sourceImage, $fullPath, 80);
        imagedestroy($sourceImage);
        
        return $path . '/' . $filename;
    }
}
