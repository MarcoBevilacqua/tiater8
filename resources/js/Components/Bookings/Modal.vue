<template>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div
        aria-labelledby="modal-title"
        aria-modal="true"
        class="fixed z-10 inset-0 overflow-y-auto"
        role="dialog"
    >
        <div class="min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!--
      Background overlay, show/hide based on modal state.

      Entering: "ease-out duration-300"
        From: "opacity-0"
        To: "opacity-100"
      Leaving: "ease-in duration-200"
        From: "opacity-100"
        To: "opacity-0"
    -->
            <div
                aria-hidden="true"
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
            ></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span
                aria-hidden="true"
                class="hidden sm:inline-block sm:align-middle sm:h-screen"
            >&#8203;</span
            >

            <!--
      Modal panel, show/hide based on modal state.

      Entering: "ease-out duration-300"
        From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        To: "opacity-100 translate-y-0 sm:scale-100"
      Leaving: "ease-in duration-200"
        From: "opacity-100 translate-y-0 sm:scale-100"
        To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    -->
            <div
                class="inline-block align-bottom bg-white rounded-lg text-center overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-1/4"
            >
                <div class="bg-white px-8 pt-2 pb-2 sm:pt-6 sm:pb-4">
                    <div v-if="booking" class="text-center sm:mt-0 sm:pt-2 sm:pb-6 sm:text-center">
                        <h2
                            class="text-lg leading-6 font-medium font-bold text-gray-900">
                            Conferma modifica posto </h2>
                        <div>
                            <span class="text-md">Nominativo: {{ this.booking.customer.first_name }}
                            {{ this.booking.customer.last_name }}</span>
                        </div>
                        <small class="fw-bold"> Modifica posto da
                            {{ this.$parent.row }}{{ this.$parent.place }} a {{ row + place }}</small>
                    </div>
                    <div v-else>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Selezionare nominativo</h3>
                        <small>Fila {{ row }} Posto {{ place }}</small>
                        <div class="mt-2"></div>
                    </div>

                    <div v-if="booking" class="text-center sm:mt-0 sm:pt-6 sm:pb-4 sm:text-center">
                        <form @submit.prevent="update">
                            <button
                                class="w-1/3 inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-1/2 sm:text-sm"
                                type="submit"
                            >
                                Conferma
                            </button>
                        </form>
                    </div>
                    <div v-else class="px-6 pt-2 pb-4 sm:px-8">
                        <form @submit.prevent="create">
                            <select
                                id="customer_id"
                                v-model="form.customer_id"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                name="customer_id"
                                required
                            >
                                <option
                                    v-for="customer in this.$parent.customers"
                                    :value="customer.id"
                                >{{ customer.name }}
                                </option>
                            </select>
                            <div class="my-4"></div>
                            <button
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-full sm:text-sm"
                                type="submit"
                            >
                                Aggiorna
                            </button>
                        </form>
                    </div>
                </div>
                <div class="bg-gray-50 hover:bg-gray-100 px-4 py-2 sm:px-6">
                    <a
                        class="cursor-pointer mt-3 w-full hover:bg-gray-100 inline-flex justify-center px-4 py-2 bg-transparent text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm"
                        @click="$emit('close-modal')"
                    >
                        Annulla
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        booking: Object,
        place: Number,
        row: String,
        showEventId: Number
    },
    data() {
        return {
            form: this.$inertia.form({
                id: 1,
                customer_id: null,
                show_event_id: null,
                place: null,
                row: null,
            })
                .transform((data) => ({
                    ...data,
                    show_event_id: this.showEventId,
                    place: this.$props.place,
                    row: this.$props.row,
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
    },
};
</script>
