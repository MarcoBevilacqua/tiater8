<template>
    <div :class="'grid gap-4 grid-cols-' + places">
        <div v-for="place in places" key="place">
            <div class="col-span-1">
                <div
                    class="flex justify-center mt-2 px-6 py-2 text-center rounded bg-gray-200"
                >
                    <!-- PLACE BOOKED BY SELECTED CUSTOMER::START -->
                    <button
                        v-if="isPlaceBookedByCustomer(row, place)"
                        :class="[custom ? 'rounded-full' : 'rounded-lg', 'rounded-lg']"
                        class="block bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 text-white font-medium text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button"
                        @click="
                            $emit(
                                'show-modal',
                                row,
                                place,
                                getBookedCustomer(place)
                            )
                        "
                    >
                        <span
                            class="text-sm">{{ row }}{{ place }}</span>
                    </button>
                    <!-- PLACE BOOKED BY SELECTED CUSTOMER::END -->
                    <!-- PLACE BOOKED BY OTHER CUSTOMER::START -->
                    <button
                        v-if="isPlaceBooked(place) && !isPlaceBookedByCustomer(row, place)"
                        :class="[custom ? 'rounded-full' : 'rounded-lg', 'rounded-lg']"
                        class="cursor-not-allowed block bg-gray-500 focus:ring-4 focus:ring-blue-300 text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button"
                    >
                        <span class="text-sm">{{ row }}{{ place }}</span>
                    </button>
                    <!-- PLACE BOOKED BY OTHER CUSTOMER::END -->
                    <!-- PLACE NOT BOOKED::START -->
                    <button
                        v-if="!isPlaceBooked(place) && !isPlaceBookedByCustomer(row, place)"
                        :class="[custom ? 'rounded-full' : 'rounded-lg', 'rounded-lg']"
                        class="block bg-green-600 hover:bg-green-800 focus:ring-4 focus:ring-gray-300' text-white font-medium text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button"
                        @click="$emit('show-modal', row, place)"
                    >
                        <span class="text-sm">{{ row }}{{ place }}</span>
                    </button>
                    <!-- PLACE NOT BOOKED::END -->
                </div>
            </div>
        </div>
    </div>
</template
>

<script>
export default {
    props: {
        custom: Boolean,
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
        isPlaceBookedByCustomer(row, place) {
            return row + place === this.$parent.customerBooking.row_letter + this.$parent.customerBooking.place_number;
        },
        getBookedCustomer() {
            return this.bookedPlaces[0]?.customer_id;
        },
    },
};
</script>
