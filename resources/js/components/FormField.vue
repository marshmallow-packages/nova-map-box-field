<template>
    <DefaultField
        :field="currentField"
        :errors="errors"
        :show-help-text="showHelpText"
    >
        <template #field>
            <div
                class="mm-rounded-t-lg mm-border-b border-gray-200"
                :id="currentField.attribute + '_map'"
                :style="{
                    height: currentField.height,
                }"
            ></div>
        </template>
    </DefaultField>
</template>

<script>
    import { DependentFormField, HandlesValidationErrors } from "laravel-nova";
    import mapboxgl from "mapbox-gl";
    import MapboxDraw from "@mapbox/mapbox-gl-draw";

    export default {
        mixins: [HandlesValidationErrors, DependentFormField],

        props: ["resourceName", "resourceId", "field"],

        data: {
            map: null,
            polygon_count: 0,
            prefilled_indexes: [],
        },

        methods: {
            onSyncedField() {
                let i = 0;

                for (let i = 0; i < this.prefilled_indexes.length; i++) {
                    let polygon_id = this.prefilled_indexes[i];
                    if (this.map.getLayer(polygon_id))
                        this.map.removeLayer(polygon_id);
                    if (this.map.getSource(polygon_id))
                        this.map.removeSource(polygon_id);
                }

                this.prefilled_indexes = [];

                this.drawPrefilledPolygons(this.currentField.prefill_with);
            },
            /*
             * Set the initial, internal value for the field.
             */
            setInitialValue() {
                this.value = this.currentField.value || "";
            },

            /**
             * Fill the given FormData object with the field's internal value.
             */
            fill(formData) {
                formData.append(this.currentField.attribute, this.value || "");
            },

            drawPrefilledPolygons(prefill_map_with) {
                if (prefill_map_with) {
                    let self = this;
                    prefill_map_with.forEach(function (data, index) {
                        self.polygon_count++;
                        let polygon_id = "polygon_" + index;

                        if (self.prefilled_indexes.includes(polygon_id)) {
                            return;
                        }

                        self.prefilled_indexes.push(polygon_id);
                        self.map.addSource(polygon_id, {
                            type: "geojson",
                            data: data.polygon,
                        });

                        self.map.addLayer({
                            id: polygon_id,
                            type: "fill",
                            source: polygon_id,
                            layout: {},
                            paint: {
                                "fill-color": data.color,
                                "fill-opacity": data.opacity,
                            },
                        });
                    });
                }
            },
        },

        mounted() {
            let field = this;

            mapboxgl.accessToken = this.currentField.map_box_public_token;

            this.map = new mapboxgl.Map({
                container: this.currentField.attribute + "_map",
                style: this.currentField.style,
                zoom: this.currentField.default_zoom,
                center: [
                    this.currentField.longitude,
                    this.currentField.latitude,
                ],
            });

            if (this.currentField.navigation_controls) {
                // Add zoom and rotation controls to the map.
                this.map.addControl(new mapboxgl.NavigationControl());
            }

            const draw = new MapboxDraw({
                displayControlsDefault: this.currentField.draw_controls,
                controls: {
                    polygon: true,
                    trash: true,
                },
                defaultMode: "draw_polygon",
            });

            this.map.addControl(draw);

            this.map.on("draw.create", updateArea);
            this.map.on("draw.delete", updateArea);
            this.map.on("draw.update", updateArea);

            let prefill_map_with = this.currentField.prefill_with;
            let self = this;

            this.currentField.markers.forEach(function (data, index) {
                new mapboxgl.Marker()
                    .setLngLat([data[1], data[0]])
                    .addTo(self.map);
            });

            this.map.on("load", function () {
                if (field.value) {
                    draw.add(JSON.parse(field.value));
                }

                self.drawPrefilledPolygons(prefill_map_with);
            });

            function updateArea(e) {
                field.value = JSON.stringify(draw.getAll());
            }
        },
    };
</script>
