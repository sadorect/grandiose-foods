<?php

namespace App\Traits;

use Intervention\Image\Image;

trait ConvertToWebp
{
    public function convertToWebp($image, $path)
    {
        $img = $image;        $filename = uniqid() . '.webp';
        $fullPath = storage_path('app/public/' . $path . '/' . $filename);
        
        $img->encode('webp', 80)->save($fullPath);
        
        return $path . '/' . $filename;
    }
}
