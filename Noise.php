<?php
class Point
{
    public function __construct(
        public int $x,
        public int $y
    ) {
    }
}

final class Noise
{
    public function __construct(
        private int $seed,
    ) {
    }

    public function generate(Point $point): float
    {
        return $this->baseNoise($point)
            * $this->circularNoise(150, 100, $point);
    }

    private function hash(Point $point): float
    {
        $baseX = ceil($point->x / 10);
        $baseY = ceil($point->y / 10);

        # The bin2hex() function converts a string of ASCII characters to hexadecimal values
        $hash = bin2hex(
            hash(
                # xxHash is an 'extremely fast hashing algorithm'
                algo: 'xxh32',
                data: $this->seed * $baseX * $baseY,
            )
        );

        $hash = floatval('0.' . $hash);

        return $hash;
    }

    private function baseNoise(Point $point): float
    {
        if ($point->x % 10 === 0 && $point->y % 10 === 0) {
            $noise = $this->hash($point);
        } elseif ($point->x % 10 === 0) {
            $topPoint = new Point(
                x: $point->x,
                y: (floor($point->y / 10) * 10),
                // The closest point divisible by 10, above our current pixel
            );

            $bottomPoint = new Point(
                x: $point->x,
                y: (ceil($point->y / 10) * 10),
                // The closest point divisible by 10, bellow our current pixel
            );

            $noise = linear_interpolation(
                // The hash value (or color) of that top point:
                a: $this->hash($topPoint),

                // The hash value (or color) of that bottom point:
                b: $this->hash($bottomPoint),

                // The distance between our current point and the top point
                // - the fraction
                fraction: ($point->y - $topPoint->y) / ($bottomPoint->y - $topPoint->y),
            );
        } elseif ($point->y % 10 === 0) {
            $leftPoint = new Point(
                x: (floor($point->x / 10) * 10),
                y: $point->y,
            );

            $rightPoint = new Point(
                x: (ceil($point->x / 10) * 10),
                y: $point->y,
            );

            $noise = linear_interpolation(
                $this->hash($leftPoint),
                $this->hash($rightPoint),
                ($point->x - $leftPoint->x) / ($rightPoint->x - $leftPoint->x),
            );
        } else {
            $topLeftPoint = new Point(
                x: (floor($point->x / 10) * 10),
                y: (floor($point->y / 10) * 10),
            );

            $topRightPoint = new Point(
                x: (ceil($point->x / 10) * 10),
                y: (floor($point->y / 10) * 10),
            );

            $bottomLeftPoint = new Point(
                x: (floor($point->x / 10) * 10),
                y: (ceil($point->y / 10) * 10),
            );

            $bottomRightPoint = new Point(
                x: (ceil($point->x / 10) * 10),
                y: (ceil($point->y / 10) * 10),
            );

            $a = linear_interpolation(
                $this->hash($topLeftPoint),
                $this->hash($topRightPoint),
                ($point->x - $topLeftPoint->x) / ($topRightPoint->x - $topLeftPoint->x),
            );

            $b = linear_interpolation(
                $this->hash($bottomLeftPoint),
                $this->hash($bottomRightPoint),
                ($point->x - $bottomLeftPoint->x) / ($bottomRightPoint->x - $bottomLeftPoint->x),
            );

            $noise = linear_interpolation(
                $a,
                $b,
                ($point->y - $topLeftPoint->y) / ($bottomLeftPoint->y - $topLeftPoint->y),
            );
        }

        return $noise;
    }

    private function circularNoise(int $totalWidth, int $totalHeight, Point $point): float
    {
        $middleX = $totalWidth / 2;
        $middleY = $totalHeight / 2;

        $distanceFromMiddle = sqrt(
            pow(($point->x - $middleX), 2)
                + pow(($point->y - $middleY), 2)
        );

        $maxDistanceFromMiddle = sqrt(
            pow(($totalWidth - $middleX), 2)
                + pow(($totalHeight - $middleY), 2)
        );

        return 1 - ($distanceFromMiddle / $maxDistanceFromMiddle) + 0.3;
    }
}
