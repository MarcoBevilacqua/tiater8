<template>
    <breeze-authenticated-layout>
        <template #header>
            <h1>Inserisci Prenotazione</h1>
        </template>
        <template #main>
            <container>
                <div class="mt-10 sm:mt-5">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="mt-10 md:mt-5 md:col-span-3">
                            <form @submit.prevent="create">
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <input
                                        type="hidden"
                                        v-model="form.id"
                                        name="id"
                                        id="id"
                                    />
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6 sm:col-span-3">
                                            <label
                                                for="customer_id"
                                                class="block text-sm font-medium text-gray-700"
                                                >Spettatore:</label
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
                                    </div>
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6 sm:col-span-3">
                                            <label
                                                for="show_id"
                                                class="block text-sm font-medium text-gray-700"
                                                >Spettacolo:</label
                                            >
                                            <select
                                                v-model="form.show_id"
                                                required
                                                @change="getShowEvents(1)"
                                                name="show_id"
                                                id="show_id"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            >
                                                <option
                                                    v-for="show in shows"
                                                    :value="show.id"
                                                    >{{ show.title }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div
                                        class="grid grid-cols-6 gap-6"
                                        v-if="this.form.show_id"
                                    >
                                        <div class="col-span-6 sm:col-span-3">
                                            <label
                                                for="show_date"
                                                class="block text-sm font-medium text-gray-700"
                                                >Date disponibili:</label
                                            >
                                            <select
                                                v-model="form.show_event_id"
                                                required
                                                name="show_event_id"
                                                id="show_event_id"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            >
                                                <option
                                                    v-for="show_event in show_events"
                                                    :value="show_event.id"
                                                    >{{ show_event.date }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="px-4 py-3 bg-gray-50 text-right sm:px-6"
                                >
                                    <a
                                        :href="route('bookings.index')"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-400 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 mr-3"
                                    >
                                        Torna alla lista
                                    </a>
                                    <button
                                        type="submit"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    >
                                        Prosegui
                                    </button>
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

export default {
    components: {
        Container,
        BreezeAuthenticatedLayout,
    },

    props: {
        errors: Object,
        customers: Object,
        shows: Object,
        _method: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                customer_id: this.customer_id,
                show_event_id: this.show_event_id,
                _method: this._method,
            }),
            show_events: [],
        };
    },
    methods: {
        create() {
            this.form.post(this.route("bookings.store", this.form), {
                preserveState: true,
                onError: () => this.form.reset(),
            });
        },
        getShowEvents(showId) {
            axios
                .get("http://localhost:8000/events/" + this.form.show_id)
                .then((response) => (this.show_events = response.data));
        },
    },
};
</script>
