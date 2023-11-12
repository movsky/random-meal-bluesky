<?php

namespace App\Service\ImageDownloader;

use Symfony\Component\HttpKernel\KernelInterface;

class ImageDownloader
{

    const IMAGE_PATH = '/images/';

    private string $projectDir;

    public function __construct(private readonly KernelInterface $appKernel
    )
    {
        $this->projectDir = $this->appKernel->getProjectDir();
    }

    public function download(string $uri): string
    {
        $filename = $this->extractFilename($uri);
        $imageDir = $this->projectDir . self::IMAGE_PATH . $filename;
        file_put_contents($imageDir, file_get_contents($uri));

        return $imageDir;
    }

    private function extractFilename(string $uri): string
    {
        $urlParts = explode('/', $uri);

        return end($urlParts);
    }

}