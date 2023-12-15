<?php

namespace App\Service\MealReader;

interface MealReaderInterface
{

    public function getRandom(): Meal;

}