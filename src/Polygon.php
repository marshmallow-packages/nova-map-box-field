<?php

namespace Marshmallow\MapBox;

class Polygon
{
    public function __construct(public array $polygon, public string $color, public float $opacity = 0.5)
    {
        //
    }
}
