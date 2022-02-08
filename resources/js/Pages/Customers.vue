<template>
    <breeze-authenticated-layout>
        <template #header>
            <div class="grid grid-cols-2">
                <div>
                    <h2
                        class="font-semibold text-xl text-gray-800 leading-tight"
                    >
                        Iscritti
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
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Nome
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Cognome
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Email
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            ></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr
                            v-for="customer in customers.data"
                            :key="customer.email"
                        >
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="text-sm font-medium text-gray-900"
                                    >
                                        {{ customer.first_name }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="text-sm font-medium text-gray-900"
                                    >
                                        {{ customer.last_name }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py- 4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="text-sm font-medium text-gray-900"
                                    >
                                        {{ customer.email }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py- 4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="text-sm font-medium text-gray-900"
                                    >
                                        <inertia-link
                                            class="text-indigo-600 hover:text-indigo-900"
                                            :href="customer.edit"
                                            >Modifica</inertia-link
                                        >
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination :links="customers.links" />
            </container>
        </template>
    </breeze-authenticated-layout>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
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
    },
    props: {
        customers: Object,
        createLink: String,
    },
    watch: {
        search: {
            handler: throttle(function () {
                Inertia.get(
                    "customers",
                    { search: this.search },
                    { preserveState: true, preserveScroll: true }
                );
            }, 150),
        },
    },
    data() {
        return {
            search: "",
        };
    },
};
</script>
