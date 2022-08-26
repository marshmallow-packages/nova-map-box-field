<?php

namespace Marshmallow\MapBox;

use Laravel\Nova\Fields\Field;
use Marshmallow\MapBox\Traits\Options;

class MapBox extends Field
{
    use Options;

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
            ->polygon()
            ->polygonPreviewColor(config('nova-map-box-field.default.polygon_preview.color'))
            ->polygonPreviewOpacity(config('nova-map-box-field.default.polygon_preview.opacity'))
            ->mapBoxPublicToken(
                config('nova-map-box-field.mapbox_key')
            )->randomId()
            ->hideFromIndex();
    }
}
