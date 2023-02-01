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
                            class="font-medium text-indigo-500">
                            Inserisci nuovo
                        </inertia-link>
                    </small>
                </div>
            </div>
        </template>
        <template #main>
            <container>
                <FullCalendar :options="calendarOptions"/>
            </container>
        </template>
    </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import Container from "@/Layouts/Container";
import BreezeDropdown from "@/Components/Dropdown";
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

export default {
    components: {
        BreezeDropdown,
        BreezeAuthenticatedLayout,
        Container,
        FullCalendar
    },
    props: {
        shows: Object,
        bookings: Object,
        createLink: String,
    },
    data() {
        return {
            calendarOptions: {
                plugins: [dayGridPlugin, interactionPlugin],
                initialView: 'dayGridMonth',
                dateClick: this.handleDateClick,
                locale: "it-IT",
                events: this.bookings,
            },
        };
    },

    methods: {
        handleDateClick: function (arg) {
            window.location.href = this.createLink + '?date=' + arg.dateStr
        },
    }
};
</script>
