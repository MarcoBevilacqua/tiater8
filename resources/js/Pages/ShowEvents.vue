<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Date Spettacoli
            </h2>
            <small>
                <inertia-link
                    :href="createLink"
                    class="font-medium text-indigo-500"
                    >Inserisci nuovo
                </inertia-link></small
            >
        </template>
        <template #main>
            <container>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Spettacolo
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Data
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Azioni
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="event in events" :key="event.id">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="text-sm font-medium text-gray-900"
                                    >
                                        {{ event.show }}
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
                                        {{ event.date }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py- 4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="text-sm font-medium text-gray-900"
                                    >
                                        <inertia-link
                                            class="text-blue-700 inline-flex items-center font-semibold tracking-wide"
                                            :href="'show-event.edit'"
                                            >Modifica</inertia-link
                                        >
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

export default {
    components: {
        BreezeAuthenticatedLayout,
        Container,
    },
    props: {
        events: Object,
        createLink: String,
    },
};
</script>
