<?php

namespace Dawsompablo\ProceduralGeneration\Entity;

class Pixel
{
    public function __construct(
        public int $x,
        public int $y,
        public float $value
    ) {
    }
}
