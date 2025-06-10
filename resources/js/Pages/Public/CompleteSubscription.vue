<template #guest>
    <div>
        <div class="mt-5 md:mt-10 lg:mt-10 md:px-12 lg:px-24">
            <div class="flex justify-items-center">
                <div class="w-full">
                    <img
                        :src="'/img/common/logo.jpg'"
                        alt="pci_logo"
                        class="mx-auto rounded-md"
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
                                <small
                                >(I campi contrassegnati con * sono
                                    obbligatori)</small
                                >
                            </div>
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div
                                    class="grid grid-cols-12 gap-2 md:grid-cols-6 lg:grid-cols-6 md:gap-6 lg:gap-6"
                                >
                                    <div
                                        class="col-span-12 md:col-span-2 lg:col-span-2"
                                    >
                                        <label
                                            class="block text-sm font-medium text-gray-700"
                                            for="first_name"
                                        >Nome*</label
                                        >
                                        <input
                                            id="first_name"
                                            v-model="form.first_name"
                                            autocomplete="given-name"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            name="first_name"
                                            required
                                            type="text"
                                        />
                                    </div>

                                    <div
                                        class="col-span-12 md:col-span-2 lg:col-span-2"
                                    >
                                        <label
                                            class="block text-sm font-medium text-gray-700"
                                            for="last_name"
                                        >Cognome*</label
                                        >
                                        <input
                                            id="last_name"
                                            v-model="form.last_name"
                                            autocomplete="family-name"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            name="last_name"
                                            required
                                            type="text"
                                        />
                                    </div>

                                    <div
                                        class="col-span-12 md:col-span-2 lg:col-span-2"
                                    >
                                        <label
                                            class="block text-sm font-medium text-gray-700"
                                            for="fiscal_code"
                                        >Codice Fiscale*</label
                                        >
                                        <input
                                            id="fiscal_code"
                                            v-model="form.fiscal_code"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            name="fiscal_code"
                                            required
                                            type="text"
                                        />
                                        <div
                                            v-if="errors.fiscal_code"
                                            class="text-red-700 text-xs pt-2"
                                        >
                                            {{ errors.fiscal_code }}
                                        </div>
                                    </div>

                                    <div
                                        class="col-span-8 md:col-span-2 lg:col-span-2"
                                    >
                                        <label
                                            class="block text-sm font-medium text-gray-700"
                                            for="city"
                                        >Nato a*</label
                                        >
                                        <input
                                            id="city"
                                            v-model="form.city"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            name="city"
                                            required
                                            type="text"
                                        />
                                    </div>

                                    <div
                                        class="col-span-4 md:col-span-1 lg:col-span-1"
                                    >
                                        <label
                                            class="block text-sm font-medium text-gray-700"
                                            for="province"
                                        >Provincia*</label
                                        >
                                        <input
                                            id="province"
                                            v-model="form.province"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            name="province"
                                            required
                                            type="text"
                                        />
                                    </div>

                                    <div
                                        class="col-span-6 md:col-span-2 lg:col-span-2"
                                    >
                                        <label
                                            class="block text-sm font-medium text-gray-700"
                                            for="birth"
                                        >Il*</label
                                        >
                                        <input
                                            id="birth"
                                            v-model="form.birth"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            name="birth"
                                            required
                                            type="date"
                                        />
                                        <div
                                            v-if="errors.birth"
                                            class="text-red-700 text-xs pt-2"
                                        >
                                            {{ errors.birth }}
                                        </div>
                                    </div>

                                    <div
                                        class="col-span-6 sm:col-span-2 lg:col-span-2"
                                    >
                                        <label
                                            class="block text-sm font-medium text-gray-700"
                                            for="resident"
                                        >Residente a*</label
                                        >
                                        <input
                                            id="resident"
                                            v-model="form.resident"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            name="resident"
                                            required
                                            type="text"
                                        />
                                    </div>

                                    <div
                                        class="col-span-8 md:col-span-2 lg:col-span-2"
                                    >
                                        <label
                                            class="block text-sm font-medium text-gray-700"
                                            for="address"
                                        >Indirizzo*</label
                                        >
                                        <input
                                            id="address"
                                            v-model="form.address"
                                            autocomplete="street-address"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            name="address"
                                            required
                                            type="text"
                                        />
                                    </div>

                                    <div
                                        class="col-span-4 md:col-span-1 lg:col-span-1"
                                    >
                                        <label
                                            class="block text-sm font-medium text-gray-700"
                                            for="postal_code"
                                        >CAP*</label
                                        >
                                        <input
                                            id="postal_code"
                                            v-model="form.postal_code"
                                            autocomplete="postal-code"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            name="postal_code"
                                            required
                                            type="number"
                                        />
                                    </div>

                                    <div
                                        class="col-span-8 md:col-span-2 lg:col-span-2"
                                    >
                                        <label
                                            class="block text-sm font-medium text-gray-700"
                                            for="phone"
                                        >Telefono*</label
                                        >
                                        <input
                                            id="phone"
                                            v-model="form.phone"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            name="phone"
                                            required
                                            type="text"
                                        />
                                    </div>

                                    <div
                                        class="col-span-6 md:col-span-2 lg:col-span-2"
                                    >
                                        <label
                                            class="block text-sm font-medium text-gray-700"
                                            for="contact_type"
                                        >Contatto</label
                                        >
                                        <select
                                            id="contact_type"
                                            v-model="form.contact_type"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            name="contact_type"
                                        >
                                            <option
                                                v-for="(key, value) in contacts"
                                                :key="value"
                                                :value="value"
                                            >{{ key }}
                                            </option
                                            >
                                        </select>
                                    </div>

                                    <div
                                        v-if="form.contact_type != default_contact"
                                        class="col-span-6 md:col-span-2 lg:col-span-2"
                                    >
                                        <label
                                            class="block text-sm font-medium text-gray-700"
                                            for="activity"
                                        >Per attività riguardanti
                                        </label>
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

                                    <input
                                        id="sub_token"
                                        v-model="form.sub_token"
                                        name="sub_token"
                                        type="hidden"
                                    />
                                </div>
                                <div class="py-3 bg-gray-50 text-left">
                                    <input class="rounded mx-2" type="checkbox" name="consent" required>
                                    <small>Autorizzo il trattamento dei dati personali qui o altrove dichiarati ai sensi della legge 675/96 e del D.L.196/2003, esclusivamente per lo svolgimento e la gestione delle attività legate agli scopi
                                        dell’Associazione, senza possibilità di trasferimento a terzi dei dati medesimi.</small>
                                </div>
                            </div>
                            <div
                                v-if="!form.processing"
                                class="px-4 py-3 bg-gray-50 text-center sm:px-6"
                            >
                                <button
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    type="submit"
                                >
                                    Completa il tuo tesseramento
                                </button>
                            </div>
                            <div
                                v-else
                                class="px-4 py-3 bg-gray-50 text-center sm:px-6"
                            >
                                <button
                                    class="inline-flex justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-400 hover:bg-indigo-600 transition ease-in-out duration-150 cursor-not-allowed"
                                    disabled=""
                                    type="button"
                                >
                                    <svg
                                        class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg"
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
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                            fill="currentColor"
                                        ></path>
                                    </svg>
                                    Operazione in corso...
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div
                    v-if="
                        $page.props.flash.error ||
                        (Object.keys($page.props.errors).length > 0 && show)
                    "
                    class="text-center col-span-3 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                    role="alert"
                >
                    <div v-if="$page.props.flash.error">
                        <span class="block sm:inline">{{
                                $page.props.flash.error
                            }}</span>
                    </div>
                    <div v-else>
                        <span
                            v-if="Object.keys($page.props.errors).length === 1"
                            class="block sm:inline"
                        >Errore nella compilazione dei dati</span
                        >
                        <span v-else
                        >Rilevati
                            {{ Object.keys($page.props.errors).length }}
                            errori nella compilazione dei dati.</span
                        >
                    </div>
                    <span
                        class="absolute top-0 bottom-0 right-0 px-4 py-3"
                        @click="show = false"
                    >
                        <svg
                            class="fill-current h-6 w-6 text-red-500"
                            role="button"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <title>Close</title>
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"
                            />
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Container from "@/Layouts/Container";
import {useForm} from "@inertiajs/inertia-vue3";

export default {
    components: {
        Container,
    },
    data() {
        return {
            show: true,
        };
    },
    props: {
        errors: Object,
        sub_token: String,
        contacts: Array,
        default_contact: Number,
        activities: Array,
        url: String,
    },
    watch: {
        "$page.props.flash": {
            handler() {
                this.show = true;
            },
            deep: true,
        },
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
            form
                .transform((data) => ({
                    ...data,
                    activity: (data.contact_type !== this.default_contact) ? data.activity : null,
                }))
                .post("/over/subscriptions/complete", {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => form.reset(),
                });
        }

        return {form, submit};
    },

    mounted() {
        this.form.sub_token = this.sub_token;
        this.form.contact_type = this.default_contact;
    },
};
</script>
