<?php include_once("procedural-generation.php"); ?>

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