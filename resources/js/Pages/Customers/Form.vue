<template>
    <breeze-authenticated-layout>
        <template #header>
            <div class="mt-10 sm:mt-5">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="mt-10 md:mt-5 md:col-span-3">
                        <h1 v-if="customer.id">Modifica Cliente</h1>
                        <h1 v-else>Inserisci Cliente</h1>
                        <form @submit.prevent="update">
                            <div class="shadow overflow-hidden sm:rounded-md">
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
                                                for="first_name"
                                                class="block text-sm font-medium text-gray-700"
                                                >Nome</label
                                            >
                                            <input
                                                v-model="form.first_name"
                                                type="text"
                                                name="first_name"
                                                id="first_name"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            />
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label
                                                for="last_name"
                                                class="block text-sm font-medium text-gray-700"
                                                >Cognome</label
                                            >
                                            <input
                                                v-model="form.last_name"
                                                type="text"
                                                name="last_name"
                                                id="last_name"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            />
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6 sm:col-span-3">
                                            <label
                                                for="email"
                                                class="block text-sm font-medium text-gray-700"
                                                >Email</label
                                            >
                                            <input
                                                v-model="form.email"
                                                type="email"
                                                name="subscription_email"
                                                id="subscription_email"
                                                autocomplete="email"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            />
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-8 gap-6">
                                        <div class="col-span-4 sm:col-span-4">
                                            <label
                                                for="address"
                                                class="block text-sm font-medium text-gray-700"
                                                >Indirizzo</label
                                            >
                                            <input
                                                v-model="form.address"
                                                type="text"
                                                name="address"
                                                id="address"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            />
                                        </div>
                                        <div class="col-span-2 sm:col-span-2">
                                            <label
                                                for="city"
                                                class="block text-sm font-medium text-gray-700"
                                                >Città</label
                                            >
                                            <input
                                                v-model="form.city"
                                                type="text"
                                                name="city"
                                                id="city"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            />
                                        </div>
                                        <div class="col-span-2 sm:col-span-2">
                                            <label
                                                for="phone"
                                                class="block text-sm font-medium text-gray-700"
                                                >Telefono</label
                                            >
                                            <input
                                                v-model="form.phone"
                                                type="text"
                                                name="phone"
                                                id="phone"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="px-4 py-3 bg-gray-50 text-right sm:px-6"
                                >
                                    <button
                                        type="submit"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    >
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
        customer: Array,
        _method: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                _method: this._method,
                id: this.customer.id,
                first_name: this.customer.first_name,
                last_name: this.customer.last_name,
                email: this.customer.email,
                address: this.customer.address,
                city: this.customer.city,
                phone: this.customer.phone,
            }),
        };
    },

    methods: {
        update() {
            this.form.post(this.route("customers.update", this.customer.id), {
                onSuccess: () => this.form.reset(),
            });
        },
    },
};
</script>
