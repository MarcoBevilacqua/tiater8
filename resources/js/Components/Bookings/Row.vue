<template>
    <div :class="'grid gap-4 grid-cols-' + places">
        <div v-for="place in places" key="place">
            <div class="col-span-1 single-place-container print:border">
                <div class="flex justify-center mt-2 px-6 py-2 text-center rounded-t bg-gray-200">
                    <button
                        :class="[custom ? 'rounded-full' : 'rounded-lg', 'rounded-lg', isPlaceBooked(place) ? 'bg-yellow-600 hover:bg-yellow-800' : 'bg-green-600 hover:bg-green-800']"
                        class="print:px-6 block focus:ring-4 focus:ring-blue-300 text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button"
                        @click="placeClicked(row, place)">
                        <span class="text-sm">{{ row }}{{ place }}</span>
                    </button>
                </div>
                <div v-show="isPlaceBooked(place)"
                     class="flex justify-center px-6 pb-2 text-center rounded-b-md bg-gray-200 text-sm">
                    <span class="text-xs">{{ showPlaceOwner(row, place) }}</span>
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
    data() {
        return {
            customer: {},
            showInfo: false
        }
    },
    methods: {
        placeClicked(row, place) {

            this.$emit('show-modal', row, place);
        },
        isPlaceBooked(place) {
            return this.bookedPlaces.filter(bookedPlace => {
                return bookedPlace.place_number === place
            }).length
        },
        showPlaceOwner(row, place) {
            if (!this.isPlaceBooked(place)) return;

            let info = this.$parent.bookings[row].filter(booking => {
                return booking.place_number === place
            })
            if (info) {
                return info[0].customer['last_name'];
            }
        },
        getBookedCustomer() {
            return this.bookedPlaces[0]?.customer_id;
        },
    }
};
</script>
