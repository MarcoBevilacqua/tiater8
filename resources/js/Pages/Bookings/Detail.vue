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
                    <small>
                        <inertia-link
                            :href="createLink"
                            class="font-medium text-indigo-500"
                        >Inserisci nuovo
                        </inertia-link>
                    </small
                    >
                </div>
            </div>
        </template>
        <template #main>
            <container>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            scope="col"
                        >
                            Spettatore
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            scope="col"
                        >
                            Posto
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            scope="col"
                        >
                            Data creazione
                        </th>

                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
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
                                    {{ booking.customer.name }}
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
                                    {{ booking.code }}
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
                                    {{ booking.created_at }}
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py- 4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div
                                    class="text-sm font-medium text-gray-900"
                                >
                                    <div class="relative">
                                        <breeze-dropdown
                                            align="right"
                                            width="48"
                                        >
                                            <template #trigger>
                                                    <span
                                                        class="inline-flex rounded-md"
                                                    >
                                                        <span
                                                            class="text-blue-700 inline-flex items-center font-semibold tracking-wide"
                                                        >Azioni

                                                            <svg
                                                                class="ml-2 -mr-0.5 h-4 w-4"
                                                                fill="currentColor"
                                                                viewBox="0 0 20 20"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                            >
                                                                <path
                                                                    clip-rule="evenodd"
                                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                    fill-rule="evenodd"
                                                                />
                                                            </svg>
                                                        </span>
                                                    </span>
                                            </template>

                                            <template #content>
                                                <breeze-dropdown-link
                                                    :data="{show_id: show.id, customer_id: booking.customer.id}"
                                                    :href="booking.edit"
                                                    as="button"
                                                    method="get"
                                                >
                                                    Modifica prenotazione
                                                </breeze-dropdown-link>
                                                <breeze-dropdown-link
                                                    :data="{'addPlace': true}"
                                                    :href="booking.edit"
                                                    as="button"
                                                    method="get"
                                                >
                                                    Aggiungi posti
                                                </breeze-dropdown-link>
                                            </template>
                                        </breeze-dropdown>
                                    </div>
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
        bookings: Object,
        show: Object,
        createLink: String,
    },
};
</script>
