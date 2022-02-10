<template>
    <div class="col-span-1">
        <div
            class="mt-2 px-6 py-2 text-center rounded"
            :class="this.placeBooked ? 'bg-green-400' : 'bg-gray-200'"
            @click="togglePlaceBooked(info.booked)"
        >
            <span class="text-sm">{{ row }}{{ info.idx }}</span>
        </div>
    </div></template
>

<script>
export default {
    props: {
        row: String,
        info: Object,
    },
    data() {
        return {
            placeBooked: false,
        };
    },
    methods: {
        togglePlaceBooked(booked) {
            this.placeBooked = !this.placeBooked;
        },
    },
    mounted() {
        this.placeBooked = this.info.booked;
    },
};
</script>
