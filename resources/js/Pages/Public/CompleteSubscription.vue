<template #guest>
    <container>
        <div class="mt-5 md:mt-10 lg:mt-10 md:px-12 lg:px-24">
            <div class="flex justify-items-center">
                <div class="w-full">
                    <img
                        class="mx-auto rounded-md"
                        :src="'/img/common/logo.jpg'"
                        alt="pci_logo"
                    />
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid md:grid-cols-3 md:gap-6">
                <div class="mt-10 md:mt-5 md:col-span-3">
                    <form @submit.prevent="complete">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div
                                class="px-4 py-3 bg-gray-50 text-center sm:px-6"
                            >
                                <p>Completa la tua iscrizione</p>
                            </div>
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div
                                    class="grid grid-cols-12 gap-2 md:grid-cols-6 lg:grid-cols-6 md:gap-6 lg:gap-6"
                                >
                                    <div
                                        class="col-span-12 md:col-span-2 lg:col-span-2"
                                    >
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
                                            autocomplete="given-name"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        />
                                    </div>

                                    <div
                                        class="col-span-12 md:col-span-4 lg:col-span-4"
                                    >
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
                                            autocomplete="family-name"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        />
                                    </div>

                                    <div
                                        class="col-span-8 md:col-span-2 lg:col-span-2"
                                    >
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
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        />
                                    </div>

                                    <div
                                        class="col-span-4 md:col-span-1 lg:col-span-1"
                                    >
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
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        />
                                    </div>

                                    <div
                                        class="col-span-6 md:col-span-2 lg:col-span-2"
                                    >
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
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        />
                                    </div>

                                    <div
                                        class="col-span-6 sm:col-span-2 lg:col-span-2"
                                    >
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
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        />
                                    </div>

                                    <div
                                        class="col-span-8 md:col-span-2 lg:col-span-2"
                                    >
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
                                            autocomplete="street-address"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        />
                                    </div>

                                    <div
                                        class="col-span-4 md:col-span-1 lg:col-span-1"
                                    >
                                        <label
                                            for="postal_code"
                                            class="block text-sm font-medium text-gray-700"
                                            >CAP</label
                                        >
                                        <input
                                            v-model="form.postal_code"
                                            type="number"
                                            name="postal_code"
                                            id="postal_code"
                                            autocomplete="postal-code"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        />
                                    </div>

                                    <div
                                        class="col-span-8 md:col-span-2 lg:col-span-2"
                                    >
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

                                    <div
                                        class="col-span-6 md:col-span-2 lg:col-span-2"
                                    >
                                        <label
                                            for="contact_type"
                                            class="block text-sm font-medium text-gray-700"
                                            >Contatto</label
                                        >
                                        <select
                                            v-model="form.contact_type"
                                            type="select"
                                            name="contact_type"
                                            id="contact_type"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        >
                                            <option
                                                v-for="(key, value) in contacts"
                                                :value="value"
                                                :key="value"
                                                >{{ key }}</option
                                            >
                                        </select>
                                    </div>

                                    <div
                                        class="col-span-6 md:col-span-2 lg:col-span-2"
                                    >
                                        <label
                                            for="activity"
                                            class="block text-sm font-medium text-gray-700"
                                            >Per attività riguardanti</label
                                        >
                                        <select
                                            v-model="form.activity"
                                            type="select"
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

                                    <input
                                        type="hidden"
                                        v-model="form.sub_token"
                                        name="sub_token"
                                        id="sub_token"
                                    />
                                </div>
                            </div>
                            <div
                                class="px-4 py-3 bg-gray-50 text-center sm:px-6"
                            >
                                <button
                                    type="submit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    Completa il tuo tesseramento
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </container>
</template>

<script>
import Container from "@/Layouts/Container";
import { reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";

export default {
    components: {
        Container,
    },

    props: {
        sub_token: String,
        contacts: Array,
        activities: Array,
        url: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                first_name: null,
                last_name: null,
                email: null,
                city: null,
                resident: null,
                phone: null,
                province: null,
                activity: null,
                postal_code: null,
                address: null,
                contact_type: null,
                sub_token: null,
            }),
        };
    },

    methods: {
        complete() {
            this.form.post(this.route("subscriptions.complete", this.form), {
                onSuccess: () => this.form.reset(),
            });
        },
    },

    mounted() {
        this.form.sub_token = this.sub_token;
    },
};
</script>
