<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Date Spettacoli "{{ show }}"
            </h2>
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
                            Data
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            scope="col"
                        >
                            Orario
                        </th>
                        <th
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                            scope="col"
                        >
                            Azioni
                        </th>
                    </tr>
                    </thead>
                    <tbody v-if="events.length" class="bg-white divide-y divide-gray-200">
                    <tr v-for="event in events" :key="event.id">
                        <td class="px-6 py-4 text-clip truncate whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="text-sm font-medium text-gray-900">{{ event.date }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-clip truncate whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="text-sm font-medium text-gray-900">{{ event.time }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py- 4 whitespace-nowrap">
                            <div class="text-center">
                                <div class="text-sm font-medium text-gray-900">
                                    <inertia-link
                                        :href="event.edit"
                                        class="text-blue-700 inline-flex items-center font-semibold tracking-wide">
                                        Modifica
                                    </inertia-link>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                    <tbody v-else>
                    <tr>
                        <td colspan="3" class="text-center">
                            <div class="py-2.5 text-red-400">
                                <p>Nessuna data disponibile per la modifica.</p>
                                <span>Per inserire una data procedere dal <inertia-link href="bookings" class="text-indigo-400 underline">calendario</inertia-link></span>
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
import BreezeDropdown from "@/Components/Dropdown";
import BreezeDropdownLink from "@/Components/DropdownLink";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import Container from "@/Layouts/Container";

export default {
    components: {
        BreezeDropdown,
        BreezeDropdownLink,
        BreezeAuthenticatedLayout,
        Container,
    },
    props: {
        show: String,
        events: Object,
        createLink: String,
    },
};
</script>
