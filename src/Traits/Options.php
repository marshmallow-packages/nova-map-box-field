<?php

namespace Marshmallow\MapBox\Traits;

use Illuminate\Support\Arr;
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

    public function setCenter(callable $callable)
    {
        $center = $callable($this);
        if (!$center) {
            return $this;
        }

        return $this->latitude($center[0])
            ->longitude($center[1]);
    }

    public function addMarker(callable $callable)
    {
        $marker = $callable($this);
        if (!$marker) {
            return $this;
        }

        $markers = Arr::get($this->meta(), 'markers', []);
        $markers[] = [
            $marker[0], $marker[1]
        ];

        $this->withMeta([
            'markers' => $markers,
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

    public function navigationControls(bool $navigation_controls): self
    {
        $this->withMeta([
            'navigation_controls' => $navigation_controls,
        ]);

        return $this;
    }

    public function drawControls(bool $draw_controls): self
    {
        $this->withMeta([
            'draw_controls' => $draw_controls,
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

    public function prefillWith(callable $callable): self
    {
        $prefill_data = $callable($this);
        collect($prefill_data)->each(function ($polygon) {
            if (!$polygon instanceof \Marshmallow\MapBox\Polygon) {
                throw new \Exception('The prefillWith method expects an array of Polygon objects.');
            }
        });
        $this->withMeta([
            'prefill_with' => $prefill_data,
        ]);

        return $this;
    }
}
