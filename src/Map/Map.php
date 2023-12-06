<?php

namespace Dawsompablo\ProceduralGeneration\Map;

use Dawsompablo\ProceduralGeneration\Entity\Pixel;
use Dawsompablo\ProceduralGeneration\Biomes\BiomeFactory;

class Map
{

    public function __construct()
    {
    }

    public function drawPixel(Pixel $pixel): string
    {
        $biome = BiomeFactory::for($pixel);

        $color = $biome->getPixelColor($pixel);

        return <<<HTML
        <div style="
            --x: {$pixel->x}; 
            --y: {$pixel->y};
            --pixel-color: {$color};
        "></div>
        HTML;
    }

    public function hex(float $value): string
    {
        if ($value > 1.0) {
            $value = 1.0;
        }

        $hex = dechex((int) ($value * 255));

        if (strlen($hex) < 2) {
            $hex = "0" . $hex;
        }

        return $hex;
    }

    public function linear_interpolation(float $a, float $b, float $fraction): float
    {
        return $a + $fraction * ($b - $a);
    }

    public function smooth(float $a, float $b, float $fraction): float
    {
        $smoothstep = function (float $fraction): float {
            $v1 = $fraction * $fraction;
            $v2 = 1.0  - (1.0 - $fraction) * (1.0 - $fraction);

            return $this->linear_interpolation($v1, $v2, $fraction);
        };

        return $this->linear_interpolation($a, $b, $smoothstep($fraction));
    }
}
