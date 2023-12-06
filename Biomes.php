<?php

interface Biome
{
    public function getPixelColor(Pixel $pixel): string;
}

class SeaBiome implements Biome
{
    public function getPixelColor(Pixel $pixel): string
    {
        $base = $pixel->value;

        while ($base < 0.25) {
            $base += 0.01;
        }

        $r = hex($base / 3);
        $g = hex($base / 3);
        $b = hex($base);

        return "#{$r}{$g}{$b}";
    }
}

class PlainsBiome implements Biome
{
    public function getPixelColor(Pixel $pixel): string
    {
        $g = hex($pixel->value);
        $b = hex($pixel->value / 4);

        return "#00{$g}{$b}";
    }
}

class BeachBiome implements Biome
{
    public function getPixelColor(Pixel $pixel): string
    {
        $g = hex($pixel->value);
        $b = hex($pixel->value / 4);

        return "#00{$g}{$b}";
    }
}

class ForestBiome implements Biome
{
    public function getPixelColor(Pixel $pixel): string
    {
        $g = hex($pixel->value);
        $b = hex($pixel->value / 4);

        return "#00{$g}{$b}";
    }
}

class MountainBiome implements Biome
{
    public function getPixelColor(Pixel $pixel): string
    {
        $g = hex($pixel->value);
        $b = hex($pixel->value / 4);

        return "#00{$g}{$b}";
    }
}

class BiomeFactory
{
    public static function for(Pixel $pixel): Biome
    {
        return match (true) {
            $pixel->value < 0.6 => new SeaBiome(),
            default => new PlainsBiome(),
        };
    }

    public static function make(Pixel $pixel): Biome
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
