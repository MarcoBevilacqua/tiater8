<template>
    <breeze-authenticated-layout>
        <template #header>
            <h1>Modifica Tessera # {{ subscription.id }}</h1>
        </template>
        <template #main>
            <container>
                <div class="mt-10 sm:mt-5">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="mt-10 md:mt-5 md:col-span-3">
                            <form @submit.prevent="update">
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
                                                <CustomerAutocomplete :customer-prop="customer" @customer-selected="this.customerSelected"/>
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
                                                    v-model="subscription.year_to"
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
                                                    v-model="subscription.contact_type"
                                                    name="contact_type"
                                                    id="contact_type"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                >

                                                    <option
                                                        :selected="subscription.contact_type ?? ''"
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
                                                    <option value="">Selezionare un valore</option>
                                                    <option
                                                        :selected="subscription.activity === value"
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
                                    <div class="grid grid-cols-2">
                                        <div
                                            class="grid-col-span-1 px-4 py-3 bg-gray-50 text-left sm:px-6"
                                        >
                                            <button
                                                @click="this.delete"
                                                type="button"
                                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                            >
                                                Cancella
                                            </button>
                                        </div>
                                        <div
                                            class="grid-col-span-1 px-4 py-3 bg-gray-50 text-right sm:px-6"
                                        >
                                            <a
                                                :href="
                                                    route('subscriptions.index')
                                                "
                                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-400 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-4"
                                            >
                                                Torna alla lista
                                            </a>
                                            <a
                                                v-if="subscription.status != 0 && subscription.customer_id"
                                                target="_blank"
                                                :href="
                                                    route(
                                                        'pdf.subscriptions.module',
                                                        {
                                                            subscriptionId:
                                                                subscription.id,
                                                        }
                                                    )
                                                "
                                                class="bg-white mr-4 py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                            >
                                                Stampa Modulo
                                            </a>
                                            <button
                                                type="submit"
                                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                            >
                                                Salva
                                            </button>
                                        </div>
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
import CustomerAutocomplete from "@/Shared/CustomerAutocomplete.vue";

export default {
    components: {
        CustomerAutocomplete,
        Container,
        BreezeAuthenticatedLayout,
    },

    props: {
        errors: Object,
        subscription: Object,
        customer: Object,
        _method: String,
        av_statuses: Object,
        contacts: Object,
        activities: Object,
    },

    data() {
        return {
            search: "",
            suggestions: [],
            form: this.$inertia.form({
                _method: this._method,
                id: this.subscription.id,
                customer_id: this.subscription.customer_id,
                subscription_email: this.subscription.subscription_email,
                status: this.subscription.status,
                contact_type: this.subscription.contact_type,
                activity: this.subscription.activity,
                av_statuses: this.av_statuses,
                contacts: this.contacts,
                activities: this.activities,
                year_from: this.subscription.year_from,
                year_to: this.subscription.year_to,
            }),
        };
    },

    methods: {
        customerSelected(customerId) {

            this.form.customer_id = customerId
        },
        update() {
            this.form.post(
                this.route("subscriptions.update", this.subscription.id),
                {
                    onSuccess: () => this.form.reset(),
                }
            );
        },
        delete() {
            this.form.delete(
                this.route("subscriptions.destroy", this.subscription.id)
            );
        },
    },
};
</script>
