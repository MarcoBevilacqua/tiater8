<template>
    <breeze-authenticated-layout>
        <template #header>
            <h1>Inserisci Tessera</h1>
        </template>
        <template #main>
            <container>
                <div class="mt-10 sm:mt-5">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="mt-10 md:mt-5 md:col-span-3">
                            <form @submit.prevent="create">
                                <div
                                    class="shadow overflow-hidden sm:rounded-md"
                                >
                                    <div class="px-4 py-5 bg-white sm:p-6">
                                        <input
                                            type="hidden"
                                            v-model="form.id"
                                            name="id"
                                            id="id"
                                        />
                                        <div class="grid grid-cols-6 gap-6">
                                            <div
                                                class="col-span-6 sm:col-span-3"
                                            >
                                                <label
                                                    for="customer"
                                                    class="block text-sm font-medium text-gray-700"
                                                    >Tessera di:</label
                                                >
                                                <select
                                                    v-model="form.customer_id"
                                                    required
                                                    name="customer_id"
                                                    id="customer_id"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                >
                                                    <option
                                                        v-for="customer in customers"
                                                        :value="customer.id"
                                                        >{{ customer.name }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div
                                                class="col-span-3 sm:col-span-1"
                                            >
                                                <label
                                                    for="year_from"
                                                    class="block text-sm font-medium text-gray-700"
                                                    >Anno di inizio</label
                                                >
                                                <input
                                                    v-model="form.year_from"
                                                    type="text"
                                                    name="year_from"
                                                    id="year_from"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                />
                                                <div v-if="errors.year_from">
                                                    {{ errors.year_from }}
                                                </div>
                                            </div>

                                            <div
                                                class="col-span-3 sm:col-span-1"
                                            >
                                                <label
                                                    for="year_to"
                                                    class="block text-sm font-medium text-gray-700"
                                                    >Anno di fine</label
                                                >
                                                <input
                                                    v-model="form.year_to"
                                                    type="text"
                                                    name="year_to"
                                                    id="year_to"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
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
                                                    for="contact_type"
                                                    class="block text-sm font-medium text-gray-700"
                                                    >Comunicazioni</label
                                                >
                                                <select
                                                    v-model="form.contact_type"
                                                    required
                                                    name="contact_type"
                                                    id="contact_type"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                >
                                                    <option
                                                        v-for="(key,
                                                        value) in contacts"
                                                        :value="value"
                                                        :key="value"
                                                        >{{ key }}</option
                                                    >
                                                </select>
                                            </div>

                                            <div
                                                class="col-span-3 sm:col-span-2"
                                            >
                                                <label
                                                    for="activity"
                                                    class="block text-sm font-medium text-gray-700"
                                                    >Tipo di attività</label
                                                >
                                                <select
                                                    v-model="form.activity"
                                                    name="activity"
                                                    id="activity"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                >
                                                    <option
                                                        v-for="(key,
                                                        value) in activities"
                                                        :value="value"
                                                        :key="value"
                                                        >{{ key }}</option
                                                    >
                                                </select>
                                            </div>

                                            <div
                                                class="col-span-6 sm:col-span-3"
                                            >
                                                <label
                                                    for="status"
                                                    class="block text-sm font-medium text-gray-700"
                                                    >Stato della
                                                    sottoscrizione</label
                                                >
                                                <select
                                                    v-model="form.status"
                                                    required
                                                    name="status"
                                                    id="status"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                >
                                                    <option
                                                        v-for="(key,
                                                        value) in av_statuses"
                                                        :value="value"
                                                        :key="value"
                                                        >{{ key }}</option
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
                                            type="submit"
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
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
import { useForm } from "@inertiajs/inertia-vue3";
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Container,
        BreezeAuthenticatedLayout,
    },

    props: {
        errors: Object,
        _method: String,
        av_statuses: Array,
        activities: Array,
        contacts: Array,
        customers: Array,
    },

    data() {
        return {
            form: this.$inertia.form({
                customer_id: null,
                activity: null,
                contact_type: null,
                status: null,
                year_from: null,
                year_to: null,
                _method: this._method,
            }),
        };
    },

    methods: {
        create() {
            this.form.post(this.route("subscriptions.store", this.form), {
                onSuccess: () => this.form.reset(),
            });
        },
    },
};
</script>
