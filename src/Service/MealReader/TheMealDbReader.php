<?php

namespace App\Service\MealReader;

use App\Service\ImageDownloader\ImageDownloader;

class TheMealDbReader implements MealReaderInterface
{

    public function __construct(private readonly ImageDownloader $imageDownloader)
    {
    }

    public function getRandom(): Meal
    {
        $result = file_get_contents('https://www.themealdb.com/api/json/v1/1/random.php');
        $randomMeal = json_decode($result, true);

        return new Meal(
            $randomMeal['meals'][0]['idMeal'],
            $randomMeal['meals'][0]['strMeal'],
            $randomMeal['meals'][0]['strCategory'],
            $randomMeal['meals'][0]['strArea'],
            $this->imageDownloader->download($randomMeal['meals'][0]['strMealThumb']),
            $randomMeal['meals'][0]['strSource']
        );
    }

}