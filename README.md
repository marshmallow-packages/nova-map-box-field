![alt text](https://marshmallow.dev/cdn/media/logo-red-237x46.png "marshmallow.")

# Nova MapBox Field

[![Latest Version on Packagist](https://img.shields.io/packagist/v/marshmallow/nova-map-box-field.svg?style=flat-square)](https://packagist.org/packages/marshmallow/nova-map-box-field)
[![Total Downloads](https://img.shields.io/packagist/dt/marshmallow/nova-map-box-field.svg?style=flat-square)](https://packagist.org/packages/marshmallow/nova-map-box-field)

A field for Laravel Nova to create MapBox polygons and store them into your database. Awesome stuff really!

## Installation

Install the package via Composer:

```bash
composer require marshmallow/nova-map-box-field
```

The package registers itself through Laravel's package auto-discovery, so the field's assets are served to Nova automatically.

### Publish the config file

```bash
php artisan vendor:publish --provider="Marshmallow\MapBox\FieldServiceProvider"
```

### Add your MapBox token

The field needs a public MapBox access token. Set it in your `.env`:

```dotenv
MAPBOX_PUBLIC_KEY=your-mapbox-public-token
```

## Configuration

After publishing, the defaults live in `config/nova-map-box-field.php`. Every value is used to initialise a new `MapBox` field and can be overridden per field with the methods documented under [Usage](#usage).

| Key | Default | Description |
| --- | --- | --- |
| `mapbox_key` | `env('MAPBOX_PUBLIC_KEY')` | Your public MapBox access token. |
| `default.height` | `300` | Map height in pixels. |
| `default.zoom` | `8` | Initial zoom level. |
| `default.latitude` | `52.111221` | Latitude the map is centered on. |
| `default.longitude` | `4.647251` | Longitude the map is centered on. |
| `default.style` | `mapbox://styles/mapbox/light-v10` | MapBox style URL. |
| `default.container` | `map` | DOM container identifier for the map. |
| `default.navigation_controls` | `false` | Show MapBox navigation controls. |
| `default.draw_controls` | `false` | Show the polygon drawing controls. |
| `default.polygon_preview.color` | `#ff133b` | Fill color used when previewing polygons. |
| `default.polygon_preview.opacity` | `0.5` | Fill opacity used when previewing polygons. |

## Usage

Add the field to a Nova resource. By default the field is hidden from the index view.

```php
use Marshmallow\MapBox\MapBox;

public function fields(NovaRequest $request)
{
    return [
        MapBox::make('Area', 'area'),
    ];
}
```

### Customising the map

All map options can be overridden per field. The values default to your config file.

```php
use Marshmallow\MapBox\MapBox;

MapBox::make('Area', 'area')
    ->height(400)
    ->defaultZoom(10)
    ->latitude(52.111221)
    ->longitude(4.647251)
    ->style('mapbox://styles/mapbox/streets-v11')
    ->navigationControls(true)
    ->drawControls(true)
    ->polygonPreviewColor('#ff133b')
    ->polygonPreviewOpacity(0.5);
```

### Centering the map dynamically

Use `setCenter()` to derive the center from the resource. Return an `[latitude, longitude]` array, or a falsy value to keep the current center.

```php
MapBox::make('Area', 'area')
    ->setCenter(function ($field) {
        return [52.111221, 4.647251];
    });
```

### Adding markers

`addMarker()` pushes a marker onto the map. Return an `[latitude, longitude]` array, or a falsy value to add nothing. Call it multiple times to add multiple markers.

```php
MapBox::make('Area', 'area')
    ->addMarker(fn ($field) => [52.111221, 4.647251])
    ->addMarker(fn ($field) => [51.924420, 4.477733]);
```

### A default polygon

Draw a default polygon around a coordinate within a given range in kilometres.

```php
MapBox::make('Area', 'area')
    ->defaultPolygon(latitude: 52.111221, longitude: 4.647251, range_in_km: 5);
```

### Prefilling polygons

Use `prefillWith()` to render existing polygons on the map. The callback must return an array of `Marshmallow\MapBox\Polygon` objects; anything else throws an exception.

```php
use Marshmallow\MapBox\MapBox;
use Marshmallow\MapBox\Polygon;

MapBox::make('Area', 'area')
    ->prefillWith(function ($field) {
        return [
            new Polygon(
                polygon: [[52.111221, 4.647251], [52.120000, 4.650000], [52.115000, 4.660000]],
                color: '#ff133b',
                opacity: 0.5,
            ),
        ];
    });
```

## Credits

- [Marshmallow](https://github.com/marshmallow-packages)
- [All Contributors](https://github.com/marshmallow-packages/nova-map-box-field/contributors)

## License

The MIT License. Please see the [License File](LICENSE.md) for more information.
