<?php

namespace App\Service\MealManager;

use App\Service\FeedLogger\FeedLogger;
use App\Service\MealReader\Meal;
use App\Service\MealReader\MealReader;

class MealManager
{

    public function __construct(
        private readonly MealReader $mealReader
    ) {}

    public function getMeal(): ?Meal
    {
        return $this->mealReader->getRandom();
    }

}