<?php

return [
    'mapbox_key' => env('MAPBOX_PUBLIC_KEY'),
    'default' => [
        'height' => 300,
        'zoom' => 8,
        'latitude' => 52.111221,
        'longitude' => 4.647251,
        'style' => 'mapbox://styles/mapbox/light-v10',
        'container' => 'map',

        'polygon_preview' => [
            'color' => '#ff133b',
            'opacity' => .5,
        ],
    ],
];
