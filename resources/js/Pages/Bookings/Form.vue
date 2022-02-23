<template>
    <breeze-authenticated-layout>
        <template #header>
            <div class="grid grid-cols-2">
                <div>
                    <h2
                        class="font-semibold text-xl text-gray-800 leading-tight"
                    >
                        Prenotazioni
                    </h2>
                    <small>
                        <inertia-link
                            :href="createLink"
                            class="font-medium text-indigo-500"
                            >Inserisci nuovo
                        </inertia-link></small
                    >
                </div>
                <div class="text-right">
                    <label class="block text-gray-700"></label>
                    <input
                        class="border-2 border-gray-300 bg-white h-10 px-5 rounded-md text-sm focus:outline-none"
                        type="search"
                        placeholder="Cerca..."
                        v-model="search"
                    />
                </div>
            </div>
        </template>
        <template #main>
            <container>
                <div class="container map-container">
                    <Map :customers="customers" />
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
        bookings: Object,
        customers: Object,
        createLink: String,
    },
};
</script>
