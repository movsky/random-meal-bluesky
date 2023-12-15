<?php

namespace App\Service\MealReader;

use App\Service\ImageDownloader\ImageDownloader;

class SpoonacularReader implements MealReaderInterface
{

    public function __construct(private readonly string $apiKey, private readonly ImageDownloader $imageDownloader)
    {
    }


    public function getRandom(): Meal
    {
        $result = file_get_contents('https://api.spoonacular.com/recipes/random?number=1&apiKey=' . $this->apiKey);
        $randomMeal = json_decode($result, true);

        return new Meal(
            $randomMeal['recipes'][0]['id'],
            $randomMeal['recipes'][0]['title'],
            implode(', ', $randomMeal['recipes'][0]['dishTypes']),
            null,
            $this->imageDownloader->download($randomMeal['recipes'][0]['image']),
            $randomMeal['recipes'][0]['sourceUrl'],
            $randomMeal['recipes'][0]['vegan'],
            $randomMeal['recipes'][0]['vegetarian'],
        );
    }
}