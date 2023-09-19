<template>
    <DefaultField
        :field="field"
        :errors="errors"
        :show-help-text="showHelpText"
    >
        <template #field>
            <div
                class="mm-rounded-t-lg mm-border-b border-gray-200"
                id="map"
                :style="{
                    height: field.height,
                }"
            ></div>
        </template>
    </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from "laravel-nova";
import mapboxgl from "mapbox-gl";
import MapboxDraw from "@mapbox/mapbox-gl-draw";

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ["resourceName", "resourceId", "field"],

    data: {
        map: null,
    },

    methods: {
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value || "";
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.attribute, this.value || "");
        },
    },

    mounted() {
        let field = this;

        mapboxgl.accessToken = this.field.map_box_public_token;

        this.map = new mapboxgl.Map({
            container: this.field.container,
            style: this.field.style,
            zoom: this.field.default_zoom,
            center: [this.field.longitude, this.field.latitude],
        });

        if (this.field.navigation_controls) {
            // Add zoom and rotation controls to the map.
            this.map.addControl(new mapboxgl.NavigationControl());
        }

        const draw = new MapboxDraw({
            displayControlsDefault: this.field.draw_controls,
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

        this.map.on("load", function () {
            if (field.value) {
                draw.add(JSON.parse(field.value));
            }
        });

        function updateArea(e) {
            field.value = JSON.stringify(draw.getAll());
        }
    },
};
</script>
