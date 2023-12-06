<?php

namespace Dawsompablo\ProceduralGeneration\Biomes;

use Dawsompablo\ProceduralGeneration\Entity\Pixel;
use Dawsompablo\ProceduralGeneration\Map\Map;

class SeaBiome implements IBiome
{
    public function getPixelColor(Pixel $pixel): string
    {
        $base = $pixel->value;

        while ($base < 0.25) {
            $base += 0.01;
        }

        $map = new Map();

        $r = $map->hex($base / 3);
        $g = $map->hex($base / 3);
        $b = $map->hex($base);

        return "#{$r}{$g}{$b}";
    }
}
