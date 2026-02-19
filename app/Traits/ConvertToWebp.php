<?php

namespace App\Traits;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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

        $manager = new ImageManager(new Driver());
        $optimizedImage = $manager->read($image->getRealPath())->toWebp(80);
        $optimizedImage->save($fullPath);
        
        return $path . '/' . $filename;
    }
}
