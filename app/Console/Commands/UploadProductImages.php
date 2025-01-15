<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class UploadProductImages extends Command
{
    protected $signature = 'products:upload-images {source_dir}';
    protected $description = 'Mass upload product images from source directory';

    public function handle()
    {
        $sourceDir = $this->argument('source_dir');
        $products = Product::all();
        $count = 0;

        // Add storage path verification
        $storagePath = Storage::disk('public')->path('images/products');
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0755, true);
        }
        $this->info("Storage path: {$storagePath}");

        foreach ($products as $product) {
            $cleanName = str_replace(
                ['_', ' ', '&', ',', '-', '.'], 
                '_', 
                preg_replace('/(?<!^)[A-Z]/', '_$0', strtolower($product->name))
            );
            
            $extensions = ['jpg', 'jpeg', 'png', 'gif'];
            
            foreach ($extensions as $ext) {
                $sourcePath = $sourceDir . '/' . $cleanName . '.' . $ext;
                if (file_exists($sourcePath)) {
                    $this->info("Processing image: {$sourcePath}");
                    
                    $originalImage = $this->loadImage($sourcePath, $ext);
                    $jpgImage = imagecreatetruecolor(imagesx($originalImage), imagesy($originalImage));
                    $white = imagecolorallocate($jpgImage, 255, 255, 255);
                    imagefill($jpgImage, 0, 0, $white);
                    imagecopy($jpgImage, $originalImage, 0, 0, 0, 0, imagesx($originalImage), imagesy($originalImage));
                    
                    ob_start();
                    imagejpeg($jpgImage, null, 90);
                    $jpgContent = ob_get_clean();
                    
                    $destinationPath = 'images/products' . $product->id . '.jpg';
                    Storage::disk('public')->put($destinationPath, $jpgContent);
                    
                    $this->info("Saved to: {$storagePath}/{$product->id}.jpg");
                    
                    imagedestroy($originalImage);
                    imagedestroy($jpgImage);
                    
                    $count++;
                    $this->info("Uploaded and converted image for product: {$product->name}");
                    break;
                }
            }
        }

        $this->info("Successfully uploaded {$count} product images");
    }

    private function loadImage($path, $extension)
    {
        switch (strtolower($extension)) {
            case 'png':
                return imagecreatefrompng($path);
            case 'gif':
                return imagecreatefromgif($path);
            default:
                return imagecreatefromjpeg($path);
        }
    }
}
