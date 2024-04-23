<template>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div
        aria-labelledby="modal-title"
        aria-modal="true"
        class="fixed z-10 inset-0 overflow-y-auto"
        role="dialog"
    >

        <div class="min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div
                aria-hidden="true"
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity">
            </div>
            <!-- This element is to trick the browser into centering the modal contents. -->
            <span
                aria-hidden="true"
                class="hidden sm:inline-block sm:align-middle sm:h-screen"
            >&#8203;</span
            >
            <div
                class="inline-block align-bottom bg-white rounded-lg text-center overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-1/4"
            >

                <a
                    class="bg-gray-300 hover:bg-gray-400 rounded-md float-right mt-4 mr-2 py-1.5 px-3 cursor-pointer bg-transparent text-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-2 sm:w-auto sm:text-md"
                    @click="$emit('close-modal')"
                >
                    <b>X</b>
                </a>
                <div class="bg-white px-8 pt-4 pb-4 sm:pt-12 sm:pb-8">
                    <div v-if="booking.customer"
                         class="text-center md:mt-0 md:pt-2 md:pb-2 sm:mt-0 sm:pt-2 sm:pb-4 sm:text-center">
                        <h2
                            class="text-lg leading-6 font-medium font-bold text-gray-900">
                            Modifica prenotazione</h2>
                        <div>
                            <span class="text-sm">Nominativo: {{ this.booking.customer.first_name }}
                            {{ this.booking.customer.last_name }}</span>
                        </div>
                        <div class="text-center md:pt-6 md:pb-2 sm:mt-2 sm:pt-6 sm:pb-4 sm:text-center">
                            <form @submit.prevent="update">
                                <div class="grid grid-cols-2 gap-4 md:grid-cols-12 sm:col-span-2 mb-6 text-left">
                                    <div class="col-span-1 md:col-span-4 md:col-start-3 sm:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700" for="row">Fila</label>
                                        <input v-model="form.customer_id" name="customer_id" type="hidden">
                                        <input
                                            id="row"
                                            v-model="this.booking.row_letter"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            name="row"
                                            type="text"
                                        />
                                    </div>
                                    <div class="col-span-1 md:col-span-4 md:col-start-7 sm:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700" for="place">Posto</label>
                                        <input
                                            id="place"
                                            v-model="this.booking.place_number"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            name="place"
                                            type="number"
                                        />
                                    </div>
                                </div>
                                <div class="mx-12">
                                    <button
                                        class="w-full md:w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-5 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-1/2 sm:text-sm"
                                        type="submit"
                                    >
                                        Conferma
                                    </button>
                                </div>
                            </form>


                            <button
                                class="w-full md:w-full inline-flex justify-center rounded-md border border-transparent px-5 py-2 text-red-600 font-medium hover:underline sm:w-1/2 sm:text-sm"
                                type="submit"
                                @click="deleteBooking"
                            >
                                Cancella
                            </button>

                        </div>
                    </div>
                    <div v-else>
<!--                        <h4 class="text-lg leading-6 font-medium text-gray-900">-->
<!--                            Selezionare nominativo posto {{ booking.row_letter }}{{ booking.place_number }}</h4>-->
                        <div class="mt-2"></div>
                        <div class="px-6 pt-2 pb-4 sm:px-8">
                            <form @submit.prevent="create">
                                <input type="hidden" v-model="booking.place_letter" name="place">
                                <input type="hidden" v-model="booking.row_number" name="row">

                                <CustomerAutocomplete @searching="this.form.processing = true" @customer-selected="this.customerSelected"/>
                                <div class="my-4"></div>

                                <button
                                    v-if="!form.processing"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-full sm:text-sm"
                                    type="submit"
                                >
                                    Assegna
                                </button>
                                <button
                                    v-else
                                    class="group relative w-full flex justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-400 hover:bg-indigo-600 transition ease-in-out duration-150 cursor-not-allowed"
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import CustomerAutocomplete from "../../Shared/CustomerAutocomplete"

export default {
    components: {
        CustomerAutocomplete
    },
    props: {
        booking: Object,
        showEventId: Number,
    },
    data() {
        return {
            search: "",
            suggestions: [],
            form: this.$inertia.form({
                id: this.booking ? this.booking.id : null,
                customer_id: this.booking.customer ? this.booking.customer.id : null,
                show_event_id: null,

            })
                .transform((data) => ({
                    ...data,
                    show_event_id: this.showEventId,
                    place: this.booking.place_number,
                    row: this.booking.row_letter,
                })),
        };
    },
    methods: {
        setPlace(a) {
            this.form.place = a;
        },
        create() {
            this.form.post(this.route("bookings.store", this.form), {
                onSuccess: () => this.$emit('close-modal'),
                onError: () => this.$emit('close-modal'),
            });
        },
        update() {
            this.form.put(this.route("bookings.update", this.form), {
                onSuccess: () => this.$emit('close-modal'),
                onError: () => this.$emit('close-modal'),
            });
        },
        deleteBooking() {
            this.form.delete(this.route("bookings.destroy", this.form), {
                onSuccess: () => this.$emit('close-modal'),
                onError: () => this.$emit('close-modal'),
            });
        },
        customerSelected(customerId) {
            this.form.customer_id = customerId
        }
    },

};
</script>
