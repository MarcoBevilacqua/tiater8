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
                            :data="{show_id: this.show_id}"
                            :href="createLink"
                            class="font-medium text-indigo-500"
                        >Inserisci nuovo
                        </inertia-link>
                    </small>
                </div>
                <div class="flex justify-end">
                    <div>
                        <label class="block text-gray-700"
                        >Seleziona spettacolo</label
                        >
                        <select
                            id="show_id"
                            v-model="show_id"
                            class="w-72 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md"
                            name="show_id"
                        >
                            <option v-for="show in shows" :value="show.id">
                                {{ show.title }}
                            </option
                            >
                        </select>
                    </div>
                </div>
            </div>
        </template>
        <template #main>
            <container>
                <Qalendar :events="events"/>
            </container>
        </template>
    </breeze-authenticated-layout>
</template>

<script>
import {Inertia} from "@inertiajs/inertia";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import Container from "@/Layouts/Container";
import BreezeDropdown from "@/Components/Dropdown";
import BreezeDropdownLink from "@/Components/DropdownLink";
import TableSearch from "@/Shared/TableFilter";
import {Qalendar} from "qalendar";

import '../../../node_modules/qalendar/dist/style.css';

export default {
    components: {
        BreezeDropdown,
        BreezeDropdownLink,
        BreezeAuthenticatedLayout,
        Container,
        TableSearch,
        Qalendar,
    },
    props: {
        shows: Object,
        bookings: Object,
        createLink: String,
        calendarItems: Object
    },
    data() {
        return {
            locale: 'it-IT',
            events: this.bookings,
            // if not set, the mode defaults to 'week'. The three available options are 'month', 'week' and 'day'
            // Please note, that only day and month modes are available for the calendar in mobile-sized wrappers (~700px wide or less, depending on your root font-size)
            defaultMode: 'day',
            showCurrentTime: true, // Display a line indicating the current time
            message: "",
            showDate: new Date(),
            show_id: null,
        };
    },
    watch: {
        show_id: {
            handler() {
                Inertia.get(
                    "bookings",
                    {show_id: this.show_id},
                    {
                        preserveState: true, preserveScroll: true,
                        onStart: () => {
                            this.loading = true
                        },
                        onFinish: () => {
                            this.loading = false
                        },
                    }
                );

            }
        },
    },

    methods: {}
};
</script>

<style>
#calendar {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    color: #2c3e50;
    height: 67vh;
    width: 90vw;
    margin-left: auto;
    margin-right: auto;
}

</style>
