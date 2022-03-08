<template>
    <div :class="'grid gap-4 grid-cols-' + places">
        <div v-for="place in places" key="place">
            <div class="col-span-1">
                <div
                    class="flex justify-center mt-2 px-6 py-2 text-center rounded bg-gray-200"
                >
                    <button
                        v-if="isPlaceBooked(place)"
                        @click="
                            $emit(
                                'show-modal',
                                row,
                                place,
                                getBookedCustomer(place)
                            )
                        "
                        class="block bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button"
                    >
                        <span class="text-sm">{{ row }}{{ place }}</span>
                    </button>
                    <button
                        v-else
                        @click="$emit('show-modal', row, place)"
                        class="block bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300' text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
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
    methods: {
        isPlaceBooked(place) {
            return (
                this.bookedPlaces[0]?.place_number &&
                this.bookedPlaces[0]?.place_number == place
            );
        },
        getBookedCustomer(place) {
            return this.bookedPlaces[0]?.customer_id;
        },
    },
};
</script>
