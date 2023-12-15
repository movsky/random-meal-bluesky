<?php

namespace App\Service\MealReader;

use App\Service\ImageDownloader\ImageDownloader;

class MealReaderFactory
{

    public function __construct(
        private readonly ImageDownloader $imageDownloader,
        private readonly string $spoonacularApiKey
    ) {
    }

    public function createByClassName(string $className): MealReaderInterface
    {
        if ($className === TheMealDbReader::class) {
            return new $className($this->imageDownloader);
        }

        return new $className($this->spoonacularApiKey, $this->imageDownloader);
    }

}