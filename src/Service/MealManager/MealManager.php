<?php

namespace App\Service\MealManager;

use App\Service\Logger\Logger;
use App\Service\MealReader\Meal;
use App\Service\MealReader\MealReader;

class MealManager
{

    const MAX_ATTEMPTS = 5;

    private int $attemptsCounter = 0;

    public function __construct(
        private readonly MealReader $mealReader,
        private readonly Logger $logger
    ) {}

    public function getMeal(): ?Meal
    {
        $meal = $this->mealReader->getRandom();
        $log = $this->logger->getLogAsArray();

        if (in_array($meal->getId(), $log) && $this->attemptsCounter < self::MAX_ATTEMPTS) {
            $this->attemptsCounter++;

            return $this->getMeal();
        }

        $this->logger->log($meal->getId());

        return $meal;
    }

}