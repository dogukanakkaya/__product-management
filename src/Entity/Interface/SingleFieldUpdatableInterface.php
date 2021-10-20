<?php

namespace App\Entity\Interface;

interface SingleFieldUpdatableInterface
{
    public function getUpdatableFields(): array;
}