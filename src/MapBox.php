<?php

namespace Marshmallow\MapBox;

use Laravel\Nova\Fields\Field;
use Marshmallow\MapBox\Polygon;
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
            ->navigationControls(config('nova-map-box-field.default.navigation_controls', false))
            ->drawControls(config('nova-map-box-field.default.draw_controls', false))
            ->polygon()
            ->prefillWith(function () {
                return [
                    new Polygon(json_decode('{"type": "FeatureCollection", "features": [{"id": "075bd29b98299607830385c8ab391f43", "type": "Feature", "geometry": {"type": "Polygon", "coordinates": [[[4.168581745154029, 52.01389126968695], [4.640688489219485, 52.38735629026595], [4.9096795410706875, 52.37060100788207], [5.118284846587642, 52.10165111131301], [4.486979316733084, 51.92595895199119], [4.168581745154029, 52.01389126968695]]]}, "properties": {}}]}', true), '#ff133b', .2),
                    // ('{"type": "FeatureCollection", "features": [{"id": "7299e094c7b31115e98b965eb20a79b7", "type": "Feature", "geometry": {"type": "Polygon", "coordinates": [[[4.5915289839895195, 52.103259204105825], [4.601824033537326, 52.16855556577602], [4.765172153038634, 52.163924785407374], [4.747327400487762, 52.06192565383941], [4.5915289839895195, 52.103259204105825]]]}, "properties": {}}]}'),
                    // ('{"type": "FeatureCollection", "features": [{"id": "dd6e2142a3f3c930e51d80bb74171308", "type": "Feature", "geometry": {"type": "Polygon", "coordinates": [[[4.67714546263187, 52.11797872020597], [4.643514967440382, 52.12282497621851], [4.637337937711607, 52.14094109109277], [4.6033642742014536, 52.13525426694409], [4.623611204979625, 52.11060297171579], [4.67371377944886, 52.104490712787225], [4.67714546263187, 52.11797872020597]]]}, "properties": {}}]}'),
                ];
            })
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
