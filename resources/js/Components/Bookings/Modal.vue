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
                class="inline-block align-bottom bg-white rounded-lg text-center overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-64"
            >
                <div class="bg-white px-8 pt-2 pb-2 sm:p-4 sm:pb-2">
                    <div class="text-center sm:mt-0 sm:text-center">
                        <h3 v-if="addPlace" class="text-lg leading-6 font-medium text-gray-900">
                            Confermi aggiunta posto <span class="fw-bold">{{ row + place }}</span> per la prenotazione?
                        </h3>
                        <h3 v-else class="text-lg leading-6 font-medium text-gray-900">
                            Confermi modifica posto da <span class="fw-bold">{{ this.$parent.customerBooking.row_letter
                            }}{{ this.$parent.customerBooking.place_number }}</span> a {{ row + place }}?
                        </h3>
                        <div class="mt-2"></div>
                    </div>
                </div>
                <div class="px-4 pt-2 pb-4 sm:px-6">
                    <form v-if="addPlace" @submit.prevent="create">
                        <input
                            v-model="form.show_event_id"
                            name="show_event_id"
                            type="hidden"
                        />
                        <button
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-full sm:text-sm"
                            type="submit"
                        >
                            Conferma
                        </button>
                    </form>
                    <form v-else @submit.prevent="update">
                        <button
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-full sm:text-sm"
                            type="submit"
                        >
                            Aggiorna
                        </button>
                    </form>
                </div>
                <div class="bg-gray-50 px-4 py-2 sm:px-6">
                    <a
                        class="cursor-pointer mt-3 w-full inline-flex justify-center px-4 py-2 bg-transparent text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm"
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
        addPlace: Boolean,
        customer: Object,
        showEventId: Number,
        place: Number,
        row: String,
    },
    data() {
        return {
            form: this.$inertia
                .form({
                    booking: 1,
                    customer_id: this.customer.id,
                    show_event_id: this.showEventId,
                    place: null,
                    row: null,
                })
                .transform((data) => ({
                    ...data,
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
            });
        },
        update() {
            this.form.put(this.route("bookings.update", this.form), {
                onSuccess: () => this.$emit('close-modal'),
            });
        },
    },
};
</script>
