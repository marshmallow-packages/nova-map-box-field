<?php

namespace Marshmallow\MapBox;

use Laravel\Nova\Fields\Field;
use Marshmallow\MapBox\Traits\Options;
use Laravel\Nova\Fields\SupportsDependentFields;

class MapBox extends Field
{
    use Options;
    use SupportsDependentFields;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'map-box';

    public function __construct(...$params)
    {
        parent::__construct(...$params);

        $this->height(config('nova-map-box-field.default.height'))
            ->defaultZoom(config('nova-map-box-field.default.zoom'))
            ->latitude(config('nova-map-box-field.default.latitude'))
            ->longitude(config('nova-map-box-field.default.longitude'))
            ->style(config('nova-map-box-field.default.style'))
            ->container(config('nova-map-box-field.default.container'))
            ->navigationControls(config('nova-map-box-field.default.navigation_controls', false))
            ->drawControls(config('nova-map-box-field.default.draw_controls', false))
            ->polygon()
            ->polygonPreviewColor(config('nova-map-box-field.default.polygon_preview.color'))
            ->polygonPreviewOpacity(config('nova-map-box-field.default.polygon_preview.opacity'))
            ->mapBoxPublicToken(
                config('nova-map-box-field.mapbox_key')
            )->randomId()
            ->hideFromIndex();
    }

    public function defaultPolygon(float $latitude, float $longitude, int $range_in_km): self
    {
        $this->withMeta([
            'default_polygon' => [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'range_in_km' => $range_in_km,
            ],
        ]);

        return $this;
    }
}
