<?php

namespace Dawsompablo\ProceduralGeneration\Biomes;

use Dawsompablo\ProceduralGeneration\Entity\Pixel;

interface IBiome
{
    public function getPixelColor(Pixel $pixel): string;
}
