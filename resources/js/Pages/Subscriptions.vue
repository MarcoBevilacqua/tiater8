<template>
    <breeze-authenticated-layout>
        <template #header>
            <div class="grid grid-cols-2">
                <div>
                    <h2
                        class="font-semibold text-xl text-gray-800 leading-tight"
                    >
                        Tessere socio
                    </h2>
                    <small>
                        <inertia-link
                            :href="createLink"
                            class="font-medium text-indigo-500"
                        >Inserisci nuova tessera
                        </inertia-link>
                    </small
                    >
                </div>
                <div class="text-right">
                    <label class="block text-gray-700"></label>
                    <input
                        v-model="search"
                        class="border-2 border-gray-300 bg-white h-10 px-5 rounded-md text-sm focus:outline-none"
                        placeholder="Cerca..."
                        type="search"
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
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            scope="col"
                        >
                            Iscritto
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            scope="col"
                        >
                            Stato Tessera
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            scope="col"
                        >
                            Stagione
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            scope="col"
                        >
                            Creata il
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            scope="col"
                        ></th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr
                        v-for="subscription in subscriptions.data"
                        :key="subscription.id"
                    >
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div
                                    class="text-sm font-medium text-gray-900"
                                >
                                    {{ subscription.customer }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div
                                    class="text-sm font-medium text-gray-900"
                                >
                                    {{ subscription.status }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div
                                    class="text-sm font-medium text-gray-900"
                                >
                                    {{ subscription.season }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div
                                    class="text-sm font-medium text-gray-900"
                                >
                                    {{ subscription.created }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <!-- Settings Dropdown -->
                            <div class="relative">
                                <breeze-dropdown align="right" width="48">
                                    <template #trigger>
                                            <span
                                                class="inline-flex rounded-md"
                                            >
                                                <button
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                                    type="button"
                                                >
                                                    Azioni

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
                                                </button>
                                            </span>
                                    </template>
                                    <template #content>
                                        <breeze-dropdown-link
                                            :href="
                                                    route(
                                                        'subscriptions.edit',
                                                        {
                                                            subscription: subscription,
                                                        }
                                                    )
                                                "
                                            as="button"
                                            method="get"
                                        >
                                            Modifica tessera
                                        </breeze-dropdown-link>
                                        <breeze-dropdown-link
                                            v-if="
                                                    subscription.statusID !== 3
                                                "
                                            :href="
                                                    route(
                                                        'subscriptions.update-status',
                                                        {
                                                            subscription: subscription,
                                                            status: 3,
                                                        }
                                                    )
                                                "
                                            as="button"
                                            method="patch"
                                        >
                                            Attiva Tessera
                                        </breeze-dropdown-link>
                                    </template>
                                </breeze-dropdown>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <Pagination :links="subscriptions.links"/>
            </container>
        </template>
    </breeze-authenticated-layout>
</template>

<script>
import {Inertia} from "@inertiajs/inertia";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import BreezeDropdown from "@/Components/Dropdown";
import BreezeDropdownLink from "@/Components/DropdownLink";
import Container from "@/Layouts/Container";
import Pagination from "@/Shared/Pagination";
import throttle from "lodash/throttle";

export default {
    components: {
        Pagination,
        BreezeAuthenticatedLayout,
        BreezeDropdown,
        BreezeDropdownLink,
        Container,
    },
    props: {
        links: Array,
        subscriptions: Object,
        createLink: String,
    },
    watch: {
        search: {
            handler: throttle(function () {
                Inertia.get(
                    "subscriptions",
                    {search: this.search},
                    {preserveState: true, preserveScroll: true}
                );
            }, 250),
        },
    },
    data() {
        return {
            search: "",
        };
    },
};
</script>
