<?php

namespace App\Service\MealManager;

use App\Service\Logger\Logger;
use App\Service\MealReader\MealReaderFactory;
use App\Service\MealReader\Meal;
use App\Service\MealReader\SpoonacularReader;

class MealManager
{

    const MAX_ATTEMPTS = 5;

    private int $attemptsCounter = 0;

    public function __construct(
        private readonly MealReaderFactory $mealReaderFactory,
        private readonly Logger            $logger
    ) {}

    public function getMeal(): ?Meal
    {
        $mealReader = $this->mealReaderFactory->createByClassName(SpoonacularReader::class);
        $meal = $mealReader->getRandom();
        $log = $this->logger->getLogAsArray();

        if (in_array($meal->getId(), $log) && $this->attemptsCounter < self::MAX_ATTEMPTS) {
            $this->attemptsCounter++;

            return $this->getMeal();
        }

        $this->logger->log($meal->getId());

        return $meal;
    }

}