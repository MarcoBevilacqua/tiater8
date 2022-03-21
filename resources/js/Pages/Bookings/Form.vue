<template>
    <breeze-authenticated-layout>
        <template #header>
            <div class="grid grid-cols-2">
                <div>
                    <h2
                        class="font-semibold text-xl text-gray-800 leading-tight"
                    >
                        Prenotazioni "{{ show.title }}"
                    </h2>
                    <small>{{ show.date }}</small>
                </div>
            </div>
        </template>
        <template #main>
            <container>
                <div class="container map-container">
                    <Map
                        :bookings="bookings"
                        :customers="customers"
                        :showEventId="show.id"
                        :method="_method"
                    />
                </div>
            </container>
        </template> </breeze-authenticated-layout
></template>

<script>
import { Inertia } from "@inertiajs/inertia";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import Map from "@/Components/Bookings/Map";
import Container from "@/Layouts/Container";
import Pagination from "@/Shared/Pagination";
import TableSearch from "@/Shared/TableSearch";
import throttle from "lodash/throttle";

export default {
    components: {
        Pagination,
        TableSearch,
        BreezeAuthenticatedLayout,
        Container,
        Map,
    },
    props: {
        booking: Object,
        bookings: Object,
        customers: Object,
        show: Object,
        _method: String,
    },
};
</script>
