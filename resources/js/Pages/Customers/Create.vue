<template>
    <breeze-authenticated-layout>
        <template #header>
            <h1>Inserisci Iscrizione</h1>
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
                                                for="first_name"
                                                class="block text-sm font-medium text-gray-700"
                                                >Nome</label
                                            >
                                            <input
                                                v-model="form.first_name"
                                                type="text"
                                                name="first_name"
                                                id="first_name"
                                                required
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            />
                                            <div v-if="errors.first_name">
                                                {{ errors.first_name }}
                                            </div>
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
                                                required="true"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            />
                                            <div v-if="errors.last_name">
                                                {{ errors.last_name }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-6 gap-6 mt-6">
                                        <div class="col-span-6 sm:col-span-3">
                                            <label
                                                for="email"
                                                class="block text-sm font-medium text-gray-700"
                                                >Email</label
                                            >
                                            <input
                                                v-model="form.email"
                                                type="email"
                                                required
                                                name="subscription_email"
                                                id="subscription_email"
                                                autocomplete="email"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            />
                                            <div v-if="errors.email">
                                                {{ errors.email }}
                                            </div>
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
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
                                                required
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            />
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-6 gap-6 mt-6">
                                        <div class="col-span-3 sm:col-span-2">
                                            <label
                                                for="city"
                                                class="block text-sm font-medium text-gray-700"
                                                >Nato a</label
                                            >
                                            <input
                                                v-model="form.city"
                                                type="text"
                                                name="city"
                                                id="city"
                                                required
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            />
                                        </div>

                                        <div class="col-span-1 sm:col-span-1">
                                            <label
                                                for="province"
                                                class="block text-sm font-medium text-gray-700"
                                                >Provincia</label
                                            >
                                            <input
                                                v-model="form.province"
                                                type="text"
                                                name="province"
                                                id="province"
                                                required
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            />
                                        </div>

                                        <div class="col-span-2 sm:col-span-1">
                                            <label
                                                for="birth"
                                                class="block text-sm font-medium text-gray-700"
                                                >Il</label
                                            >
                                            <input
                                                v-model="form.birth"
                                                type="date"
                                                name="birth"
                                                id="birth"
                                                required
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            />
                                        </div>

                                        <div
                                            class="col-span-2 md:col-span-2 lg:col-span-2"
                                        >
                                            <label
                                                for="fiscal_code"
                                                class="block text-sm font-medium text-gray-700"
                                                >Codice Fiscale</label
                                            >
                                            <input
                                                v-model="form.fiscal_code"
                                                type="text"
                                                name="fiscal_code"
                                                id="fiscal_code"
                                                required
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            />
                                            <div v-if="errors.fiscal_code">
                                                {{ errors.fiscal_code }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-6 gap-6 mt-6">
                                        <div class="col-span-3 sm:col-span-2">
                                            <label
                                                for="resident"
                                                class="block text-sm font-medium text-gray-700"
                                                >Residente a</label
                                            >
                                            <input
                                                v-model="form.resident"
                                                type="text"
                                                name="resident"
                                                id="resident"
                                                required
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            />
                                        </div>
                                        <div class="col-span-3 sm:col-span-3">
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
                                                required
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            />
                                        </div>

                                        <div
                                            class="col-span-1 sm:col-span-1 lg:col-span-1"
                                        >
                                            <label
                                                for="postal_code"
                                                class="block text-sm font-medium text-gray-700"
                                                >CAP</label
                                            >
                                            <input
                                                v-model="form.postal_code"
                                                type="text"
                                                name="postal_code"
                                                id="postal_code"
                                                required
                                                autocomplete="postal-code"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="px-4 py-3 bg-gray-50 text-right sm:px-6"
                                >
                                    <a
                                        :href="route('customers.index')"
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
        customer: Array,
        _method: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                first_name: null,
                last_name: null,
                email: null,
                address: null,
                city: null,
                phone: null,
                postal_code: null,
                fiscal_code: null,
                resident: null,
                birth: null,
                _method: this._method,
            }),
        };
    },

    methods: {
        create() {
            this.form.post(this.route("customers.store", this.form), {
                onSuccess: () => this.form.reset(),
            });
        },
    },
};
</script>
