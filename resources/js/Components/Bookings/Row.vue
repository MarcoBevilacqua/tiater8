<template>
    <div :class="'grid gap-4 grid-cols-' + places">
        <div v-for="place in places" key="place">
            <div class="col-span-1">
                <div
                    class="mt-2 px-6 py-2 text-center rounded"
                    :class="this.placeBooked ? 'bg-green-400' : 'bg-gray-200'"
                >
                    <button
                        @click="$emit('show-modal', row, place)"
                        class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
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
import Place from "@/Components/Bookings/Place";

export default {
    components: {
        Place,
    },
    props: {
        places: Number,
        row: String,
        info: Object,
    },
};
</script>
