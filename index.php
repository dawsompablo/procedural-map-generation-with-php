<?php
include_once("vendor/autoload.php");

use Dawsompablo\ProceduralGeneration\Noise\Noise;
use Dawsompablo\ProceduralGeneration\Map\Map;
use Dawsompablo\ProceduralGeneration\Entity\Pixel;
use Dawsompablo\ProceduralGeneration\Entity\Point;

$pixels = [];

const WIDTH = 100;
const HEIGHT = 100;
const SEED = 100;

$map = new Map();
$noise = new Noise(SEED);

for ($x = 0; $x <= WIDTH; $x++) {
    for ($y = 0; $y <= HEIGHT; $y++) {
        $pixels[$x][$y] = $map->drawPixel(new Pixel($x, $y, $noise->generate(new Point($x, $y))));
    }
}

?>

<style>
    :root {
        --pixel-size: 6px;
        --pixel-gap: 0;
        --pixel-color: #000;
    }

    * {
        margin: 0;
        padding: 0;
    }

    .map {
        display: grid;

        grid-template-columns: repeat(<?= count($pixels) ?>, var(--pixel-size));
        grid-auto-rows: var(--pixel-size);
        grid-gap: var(--pixel-gap);
    }

    .map>div {
        width: var(--pixel-size);
        height: 100%;
        grid-area: var(--y) / var(--x) / var(--y) / var(--x);
        background-color: var(--pixel-color);
    }
</style>

<div class="map">
    <?php
    foreach ($pixels as $x => $row) {
        foreach ($row as $y => $pixel) {
            echo $pixel;
        }
    }
    ?>
</div>

<!-- BASED ON: https://stitcher.io/blog/procedurally-generated-game-in-php -->