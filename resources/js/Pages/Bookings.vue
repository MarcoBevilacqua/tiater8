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
                    </small
                    >
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
                <div v-if="this.loading"
                     class="relative w-1/2 h-auto mx-auto bg-gray-50 text-center sm:px-6">
                    <div class="absolute inset-0 px-4 py-3">
                        <svg
                            class="animate-spin mx-auto h-10 w-10 text-indigo-500"
                            fill="none"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            ></circle>
                            <path
                                class="opacity-75"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                fill="currentColor"
                            ></path>
                        </svg>
                    </div>
                </div>
                <div v-if="bookings.length == 0 && !this.loading">
                    <div class="text-center mx-auto p-4 text-lg">
                        <p>Seleziona uno spettacolo dal menu a tendina</p>
                    </div>
                </div>
                <table v-if="!this.loading && bookings.length > 0" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            scope="col"
                        >
                            Data
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            scope="col"
                        >
                            Posti
                        </th>
                        <th
                            class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                            scope="col"
                        >
                            Azioni
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="booking in bookings" :key="booking.id">
                        <td
                            class="px-6 py-4 text-clip truncate whitespace-nowrap"
                        >
                            <div class="flex items-center">
                                <div
                                    class="text-sm font-medium text-gray-900"
                                >
                                    {{ booking.date }}
                                </div>
                            </div>
                        </td>
                        <td

                            class="px-6 py-4 text-clip truncate whitespace-nowrap"
                        >
                            <div class="flex items-center">
                                <div
                                    class="text-sm font-medium text-gray-900"
                                >
                                    {{ booking.total }}/50
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py- 4 whitespace-nowrap">
                            <div class="text-center">
                                <div
                                    class="text-sm font-medium text-gray-900"
                                >
                                    <inertia-link
                                        v-if="booking.total > 0"
                                        :href="booking.detail"
                                        class="text-blue-700 inline-flex items-center font-semibold tracking-wide"
                                        method="get"
                                    >
                                        Tutte le prenotazioni
                                    </inertia-link>
                                    <inertia-link
                                        v-else
                                        :data="{show_event_id: booking.show_event_id}"
                                        :href="booking.create"
                                        class="text-blue-700 inline-flex items-center font-semibold tracking-wide"
                                        method="get"
                                    >
                                        Inserisci prenotazione
                                    </inertia-link>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
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

export default {
    components: {
        BreezeDropdown,
        BreezeDropdownLink,
        BreezeAuthenticatedLayout,
        Container,
        TableSearch,
    },

    props: {
        shows: Object,
        bookings: Object,
        createLink: String,
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
    data() {
        return {
            show_id: null,
            loading: false
        };
    },
};
</script>
