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
        $meal = $this->mealReader->getRandom();

        /*
        $log = $this->feedLogger->getLogAsArray();

        if (in_array($news->getId(), $log)) {
            $this->removeCurrentFeed();

            return $this->getMeal();
        }

        $this->feedLogger->log($news->getId());
        */

        return $meal;
    }

}