<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    
    public function handle()
    {
        SitemapGenerator::create(config('app.url'))
            ->hasCrawled(function (\Spatie\Sitemap\Crawler\Url $url) {
                if ($url->segment(1) === 'products') {
                    $url->setPriority(0.8);
                }
                return $url;
            })
            ->writeToFile(public_path('sitemap.xml'));
    }
}
