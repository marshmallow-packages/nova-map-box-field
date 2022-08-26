<template>
    <div
        class="flex flex-col md:flex-row -mx-6 px-6 py-2 md:py-0 space-y-2 md:space-y-0"
        dusk="mapbox_field_1"
    >
        <div class="md:w-1/4 md:py-3">
            <h4 class="font-bold md:font-normal">
                <span>{{ field.name }}</span>
            </h4>
        </div>
        <div class="md:w-3/4 md:py-3 break-all lg:break-words">
            <div
                class="mm-rounded-t-lg mm-border-b border-gray-200"
                id="map"
                :style="{
                    height: field.height,
                }"
            ></div>
        </div>
    </div>
</template>

<script>
import mapboxgl from "mapbox-gl";

export default {
    props: ["index", "resource", "resourceName", "resourceId", "field"],

    mounted() {
        let field_value = this.field.value;
        let random_id = this.field.random_id;
        let polygon_preview_color = this.field.polygon_preview_color;
        let polygon_preview_opacity = this.field.polygon_preview_opacity;

        mapboxgl.accessToken = this.field.map_box_public_token;

        let map = new mapboxgl.Map({
            container: this.field.container,
            style: this.field.style,
            zoom: this.field.default_zoom,
            center: [this.field.longitude, this.field.latitude],
        });

        if (field_value) {
            map.on("load", function () {
                let parsed_data = JSON.parse(field_value);

                map.addSource(random_id, {
                    type: "geojson",
                    data: parsed_data,
                });

                map.addLayer({
                    id: random_id,
                    type: "fill",
                    source: random_id,
                    layout: {},
                    paint: {
                        "fill-color": polygon_preview_color,
                        "fill-opacity": polygon_preview_opacity,
                    },
                });
            });
        }
    },
};
</script>
