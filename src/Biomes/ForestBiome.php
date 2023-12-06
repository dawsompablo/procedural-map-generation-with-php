<?php

namespace Dawsompablo\ProceduralGeneration\Biomes;

use Dawsompablo\ProceduralGeneration\Entity\Pixel;
use Dawsompablo\ProceduralGeneration\Map\Map;

class ForestBiome implements IBiome
{
    public function getPixelColor(Pixel $pixel): string
    {
        $map = new Map();

        $g = $map->hex($pixel->value);
        $b = $map->hex($pixel->value / 4);

        return "#00{$g}{$b}";
    }
}
