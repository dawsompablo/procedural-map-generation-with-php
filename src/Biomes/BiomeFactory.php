<?php

namespace Dawsompablo\ProceduralGeneration\Biomes;

use Dawsompablo\ProceduralGeneration\Entity\Pixel;

class BiomeFactory
{
    public static function for(Pixel $pixel): IBiome
    {
        return match (true) {
            $pixel->value < 0.6 => new SeaBiome(),
            default => new PlainsBiome(),
        };
    }

    public static function make(Pixel $pixel): IBiome
    {
        return match (true) {
            $pixel->value < 0.4 => new SeaBiome(),
            $pixel->value >= 0.4 && $pixel->value < 0.44 => new BeachBiome(),
            $pixel->value >= 0.6 && $pixel->value < 0.8 => new ForestBiome(),
            $pixel->value >= 0.8 => new MountainBiome(),
            default => new PlainsBiome(),
        };
    }
}
