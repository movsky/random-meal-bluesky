<?php

namespace App\Service\MealReader;

class Meal
{

    public function __construct(
        private readonly string $id,
        private readonly string $title,
        private readonly string $category,
        private readonly ?string $area,
        private readonly string $image,
        private readonly ?string $source,
        private readonly bool $isVegan = false,
        private readonly bool $isVegetarian = false,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getArea(): ?string
    {
        return $this->area;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function isVegan(): bool
    {
        return $this->isVegan;
    }

    public function isVegetarian(): ?bool
    {
        return $this->isVegetarian;
    }

}