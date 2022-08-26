<?php

namespace Marshmallow\MapBox\Traits;

use Illuminate\Support\Str;

trait Options
{
    public function polygon(): self
    {
        $this->withMeta([
            'mapbox_type' => 'polygon',
        ]);

        return $this;
    }

    public function latitude(float $latitude): self
    {
        $this->withMeta([
            'latitude' => $latitude,
        ]);

        return $this;
    }

    public function longitude(float $longitude): self
    {
        $this->withMeta([
            'longitude' => $longitude,
        ]);

        return $this;
    }

    public function defaultZoom(int $default_zoom): self
    {
        $this->withMeta([
            'default_zoom' => $default_zoom,
        ]);

        return $this;
    }

    public function style(string $style): self
    {
        $this->withMeta([
            'style' => $style,
        ]);

        return $this;
    }

    public function container(string $container): self
    {
        $this->withMeta([
            'container' => $container,
        ]);

        return $this;
    }

    public function height(int $height): self
    {
        $this->withMeta([
            'height' => "{$height}px",
        ]);

        return $this;
    }

    public function mapBoxPublicToken(string $token): self
    {
        $this->withMeta([
            'map_box_public_token' => $token,
        ]);

        return $this;
    }

    public function randomId(): self
    {
        $this->withMeta([
            'random_id' => Str::random(),
        ]);

        return $this;
    }

    public function polygonPreviewColor(string $color): self
    {
        $this->withMeta([
            'polygon_preview_color' => $color,
        ]);

        return $this;
    }

    public function polygonPreviewOpacity(int|float $opacity): self
    {
        $this->withMeta([
            'polygon_preview_opacity' => $opacity,
        ]);

        return $this;
    }
}
