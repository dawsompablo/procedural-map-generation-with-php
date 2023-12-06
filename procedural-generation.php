<?php
require 'Noise.php';

class Pixel
{
    public function __construct(
        public int $x,
        public int $y,
        public float $value
    ) {
    }
}

require 'Biomes.php';

function drawPixel(Pixel $pixel): string
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

function hex(float $value): string
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

function linear_interpolation(float $a, float $b, float $fraction): float
{
    return $a + $fraction * ($b - $a);
}

function smooth(float $a, float $b, float $fraction): float
{
    $smoothstep = function (float $fraction): float {
        $v1 = $fraction * $fraction;
        $v2 = 1.0  - (1.0 - $fraction) * (1.0 - $fraction);

        return linear_interpolation($v1, $v2, $fraction);
    };

    return linear_interpolation($a, $b, $smoothstep($fraction));
}

# Noise Generation
$pixels = [];

const WIDTH = 100;
const HEIGHT = 100;
const SEED = 100;

$noise = new Noise(SEED);

for ($x = 0; $x <= WIDTH; $x++) {
    for ($y = 0; $y <= HEIGHT; $y++) {
        $pixels[$x][$y] = drawPixel(
            new Pixel(
                $x,
                $y,
                $noise->generate(new Point($x, $y))
            )
        );
    }
}
