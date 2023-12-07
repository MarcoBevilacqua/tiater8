<template>
    <breeze-authenticated-layout>
        <template #header>
            <h1>Inserisci Tessera</h1>
        </template>
        <template #main>
            <container>
                <div class="mt-10 sm:mt-5">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="mt-10 mx-auto md:mt-5 md:col-span-3">
                            <form @submit.prevent="create">
                                <div
                                    class="shadow overflow-hidden sm:rounded-md"
                                >
                                    <div class="w-full inline-flex py-4 bg-gray-300">
                                        <div class="ml-6 mr-2">
                                            <span class="font-bold">Nuova Tessera PCI</span>
                                        </div>
                                    </div>
                                    <div class="px-4 py-5 bg-white sm:p-6">
                                        <div class="grid grid-cols-6 gap-6">
                                            <div
                                                class="col-span-4 sm:col-span-4"
                                            >
                                                <CustomerAutocomplete @customer-selected="this.customerSelected"/>
                                            </div>

                                            <div
                                                class="col-span-1 sm:col-span-1/2"
                                            >
                                                <label
                                                    class="block text-sm font-medium text-gray-700"
                                                    for="year_from"
                                                >Anno di inizio</label
                                                >
                                                <input
                                                    id="year_from"
                                                    v-model="form.year_from"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                    name="year_from"
                                                    type="text"
                                                />
                                                <div v-if="errors.year_from">
                                                    {{ errors.year_from }}
                                                </div>
                                            </div>

                                            <div
                                                class="col-span-3 sm:col-span-1"
                                            >
                                                <label
                                                    class="block text-sm font-medium text-gray-700"
                                                    for="year_to"
                                                >Anno di fine</label
                                                >
                                                <input
                                                    id="year_to"
                                                    v-model="form.year_to"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                    name="year_to"
                                                    type="text"
                                                />
                                                <div v-if="errors.year_to">
                                                    {{ errors.year_to }}
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="grid grid-cols-6 gap-6 mt-6"
                                        >
                                            <div
                                                class="col-span-3 sm:col-span-1"
                                            >
                                                <label
                                                    class="block text-sm font-medium text-gray-700"
                                                    for="contact_type"
                                                >Comunicazioni</label
                                                >
                                                <select
                                                    id="contact_type"
                                                    v-model="form.contact_type"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                    name="contact_type"
                                                    required
                                                >
                                                    <option
                                                        v-for="(key,
                                                        value) in contacts"
                                                        :key="value"
                                                        :value="value"
                                                    >{{ key }}
                                                    </option
                                                    >
                                                </select>
                                            </div>

                                            <div
                                                class="col-span-3 sm:col-span-2"
                                            >
                                                <label
                                                    class="block text-sm font-medium text-gray-700"
                                                    for="activity"
                                                >Tipo di attività</label
                                                >
                                                <select
                                                    id="activity"
                                                    v-model="form.activity"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                    name="activity"
                                                >
                                                    <option
                                                        v-for="(key,
                                                        value) in activities"
                                                        :key="value"
                                                        :value="value"
                                                    >{{ key }}
                                                    </option
                                                    >
                                                </select>
                                            </div>

                                            <div
                                                class="col-span-6 sm:col-span-3"
                                            >
                                                <label
                                                    class="block text-sm font-medium text-gray-700"
                                                    for="status"
                                                >Stato della
                                                    sottoscrizione</label
                                                >
                                                <select
                                                    id="status"
                                                    v-model="form.status"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                    name="status"
                                                    required
                                                >
                                                    <option
                                                        v-for="(key,
                                                        value) in av_statuses"
                                                        :key="value"
                                                        :value="value"
                                                    >{{ key }}
                                                    </option
                                                    >
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="px-4 py-3 bg-gray-50 text-right sm:px-6"
                                    >
                                        <a
                                            :href="route('subscriptions.index')"
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-400 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 mr-3"
                                        >
                                            Torna alla lista
                                        </a>
                                        <button
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                            type="submit"
                                        >
                                            Salva
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </container>
        </template>
    </breeze-authenticated-layout>
</template>

<script>
import Container from "@/Layouts/Container";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import CustomerAutocomplete from "@/Shared/CustomerAutocomplete";

export default {
    components: {
        CustomerAutocomplete,
        Container,
        BreezeAuthenticatedLayout,
    },

    props: {
        errors: Object,
        _method: String,
        av_statuses: Array,
        activities: Array,
        contacts: Array,
        year_from: Number,
        year_to: Number,
    },

    data() {
        return {
            search: "",
            suggestions: [],
            form: this.$inertia.form({
                customer_id: null,
                activity: null,
                contact_type: null,
                status: null,
                year_from: this.$props.year_from,
                year_to: this.$props.year_to,
                _method: this._method,
            }),
        };
    },

    methods: {
        customerSelected(customerId) {
            this.form.customer_id = customerId
        },
        create() {
            this.form.post(this.route("subscriptions.store", this.form), {
                onSuccess: () => this.form.reset(),
            });
        },
    },

};
</script>
