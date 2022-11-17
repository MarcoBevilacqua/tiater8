<template>
    <breeze-authenticated-layout>
        <template #header>
            <h1>Nuova Prenotazione </h1>
            <small>{{ show.title }} / {{ show_event.date }}</small>
        </template>
        <template #main>
            <container>
                <div class="md:grid md:grid-cols-6 md:gap-6">
                    <div class="md:col-start-2 mt-10 md:mt-5 md:col-span-4">
                        <form @submit.prevent="create">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <input
                                    id="id"
                                    v-model="form.id"
                                    name="id"
                                    type="hidden"
                                />
                                <div class="grid grid-cols-8 gap-6">
                                    <div
                                        class="md:col-start-3 md:col-span-4 sm:col-span-3 mb-4"
                                    >
                                        <label
                                            class="block text-sm font-medium text-gray-700"
                                            for="customer_id"
                                        >Spettatore:</label
                                        >
                                        <select
                                            id="customer_id"
                                            v-model="form.customer_id"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            name="customer_id"
                                            required
                                        >
                                            <option
                                                v-for="customer in customers"
                                                :value="customer.id"
                                            >{{ customer.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="px-4 py-3 bg-gray-50 text-center sm:px-6"
                            >
                                <a
                                    :href="route('bookings.index')"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-400 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 mr-3"
                                >
                                    Torna alla lista
                                </a>
                                <button
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    type="submit"
                                >
                                    Prosegui
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </container>
        </template>
    </breeze-authenticated-layout>
</template>

<script>
import Container from "@/Layouts/Container";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";

export default {
    components: {
        Container,
        BreezeAuthenticatedLayout,
    },

    props: {
        errors: Object,
        customers: Object,
        show_event: Object,
        show: Object,
        _method: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                customer_id: this.customer_id,
                show_event_id: this.show_event.id,
                _method: this._method,
            }),
        };
    },
    methods: {
        create() {
            this.form.post(this.route("bookings.store", this.form), {
                preserveState: true,
                onError: () => this.form.reset(),
            });
        },
    },
};
</script>
