<template>
    <div :class="'grid gap-4 grid-cols-' + places">
        <div v-for="place in places" key="place">
            <div class="col-span-1">
                <div
                    class="flex justify-center mt-2 px-6 py-2 text-center rounded"
                >
                    <button
                        @click="$emit('show-modal', row, place)"
                        class="block text-white font-medium rounded-full text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        :class="
                            isPlaceBooked(place)
                                ? 'bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300'
                                : 'bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300'
                        "
                        type="button"
                    >
                        <span class="text-sm">{{ row }}{{ place }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div></template
>

<script>
export default {
    props: {
        places: Number,
        row: String,
        info: Object,
        bookedPlaces: Array,
    },
    data() {
        return {
            placeBooked: false,
        };
    },
    methods: {
        isPlaceBooked(place) {
            return this.bookedPlaces.includes(place);
        },
    },
};
</script>
