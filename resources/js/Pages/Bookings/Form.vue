<template>
    <breeze-authenticated-layout>
        <template #header>
            <div class="grid grid-cols-1">
                <div class="print:hidden">
                    <h2
                        class="font-semibold text-xl text-gray-800 leading-tight"
                    >
                        Modifica Prenotazioni
                    </h2>
                </div>
                <div>
                    <small>{{ show.title }} / {{ show.date }}</small>
                </div>
            </div>
        </template>
        <template #main>
            <container>
                <div class="container map-container">
                    <Map
                        :show-obj="this.show"
                        :bookings="bookings"
                        :showEventId="show_event.id"
                    />
                </div>
            </container>
        </template>
    </breeze-authenticated-layout
    >
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import Map from "@/Components/Bookings/Map";
import Container from "@/Layouts/Container";
import Pagination from "@/Shared/Pagination";

export default {
    components: {
        Pagination,
        BreezeAuthenticatedLayout,
        Container,
        Map,
    },
    props: {
        bookings: Object,
        show: Object,
        show_event: Object,
    },
};
</script>
