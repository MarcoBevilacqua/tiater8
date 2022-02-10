<template>
    <div :class="'grid gap-4 grid-cols-' + places">
        <div v-for="place in places" key="place">
            <Place :row="row" :info="{ idx: place, booked: false }" />
        </div></div
></template>

<script>
import Place from "@/Components/Bookings/Place";

export default {
    components: {
        Place,
    },
    props: {
        places: Number,
        row: String,
    },
};
</script>
