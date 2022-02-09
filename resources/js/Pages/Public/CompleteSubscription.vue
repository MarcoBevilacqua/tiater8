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
                    <form @submit.prevent="submit">
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
                                            required
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
                                            required
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
                                            required
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
                                            required
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        />
                                    </div>

                                    <div
                                        class="col-span-6 md:col-span-2 lg:col-span-1"
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
                                            required
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        />
                                    </div>

                                    <div
                                        class="col-span-6 md:col-span-2 lg:col-span-2"
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
                                            required
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
                                            required
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
                                            required
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
                                            required
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
                                        v-if="
                                            form.contact_type != default_contact
                                        "
                                        class="col-span-6 md:col-span-2 lg:col-span-2"
                                    >
                                        <label
                                            for="activity"
                                            class="block text-sm font-medium text-gray-700"
                                            >Per attività riguardanti
                                        </label>
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

                                    <input
                                        type="hidden"
                                        v-model="form.sub_token"
                                        name="sub_token"
                                        id="sub_token"
                                    />
                                </div>
                            </div>
                            <div
                                v-if="!form.processing"
                                class="px-4 py-3 bg-gray-50 text-center sm:px-6"
                            >
                                <button
                                    type="submit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    Completa il tuo tesseramento
                                </button>
                            </div>
                            <div
                                v-else
                                class="px-4 py-3 bg-gray-50 text-center sm:px-6"
                            >
                                <button
                                    type="button"
                                    class="inline-flex justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-400 hover:bg-indigo-600 transition ease-in-out duration-150 cursor-not-allowed"
                                    disabled=""
                                >
                                    <svg
                                        class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
                                        <circle
                                            class="opacity-25"
                                            cx="12"
                                            cy="12"
                                            r="10"
                                            stroke="currentColor"
                                            stroke-width="4"
                                        ></circle>
                                        <path
                                            class="opacity-75"
                                            fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                        ></path>
                                    </svg>
                                    Operazione in corso...
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
import { Inertia } from "@inertiajs/inertia";
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Container,
    },

    props: {
        errors: Object,
        sub_token: String,
        contacts: Array,
        default_contact: Number,
        activities: Array,
        url: String,
    },

    setup() {
        const form = useForm({
            first_name: null,
            last_name: null,
            city: null,
            resident: null,
            phone: null,
            birth: null,
            province: null,
            activity: null,
            postal_code: null,
            fiscal_code: null,
            address: null,
            contact_type: null,
            sub_token: null,
        });

        function submit() {
            form.post("/over/subscriptions/complete", {
                preserveScroll: true,
                onSuccess: () => form.reset(),
            });
        }

        return { form, submit };
    },

    mounted() {
        this.form.sub_token = this.sub_token;
        this.form.contact_type = this.default_contact;
    },
};
</script>
