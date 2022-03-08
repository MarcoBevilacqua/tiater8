<template>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div
        class="fixed z-10 inset-0 overflow-y-auto"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true"
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
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                aria-hidden="true"
            ></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span
                class="hidden sm:inline-block sm:align-middle sm:h-screen"
                aria-hidden="true"
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
                        <h3
                            class="text-lg leading-6 font-medium text-gray-900"
                            id="modal-title"
                        >
                            Assegna posto "{{ this.$parent.row
                            }}{{ this.$parent.place }}"
                        </h3>
                        <div class="mt-2"></div>
                    </div>
                </div>
                <div class="px-4 pt-2 pb-4 sm:px-6">
                    <form v-if="isUpdate" @submit.prevent="update">
                        <select
                            class="w-full my-4 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md"
                            name="customer"
                            id="customer"
                            v-model="form.customer_id"
                        >
                            <option
                                v-for="(key, value) in customerList"
                                :key="key"
                                :value="value"
                                :selected="customer"
                                >{{ key.name }}</option
                            >
                        </select>
                        <button
                            type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-full sm:text-sm"
                        >
                            Aggiorna
                        </button>
                    </form>
                    <form v-else @submit.prevent="create">
                        <input
                            type="hidden"
                            name="show_event_id"
                            v-model="form.show_event_id"
                        />
                        <select
                            class="w-full my-4 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md"
                            name="customer"
                            id="customer"
                            v-model="form.customer_id"
                        >
                            <option
                                v-for="(key, value) in customerList"
                                :key="key"
                                :value="value"
                                >{{ key.name }}</option
                            >
                        </select>
                        <button
                            type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-full sm:text-sm"
                        >
                            Conferma
                        </button>
                    </form>
                </div>
                <div class="bg-gray-50 px-4 py-2 sm:px-6">
                    <a
                        @click="$emit('close-modal')"
                        class="cursor-pointer mt-3 w-full inline-flex justify-center px-4 py-2 bg-transparent text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm"
                    >
                        Annulla
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Container from "@/Layouts/Container";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    props: {
        customerList: Object,
        customerId: Number,
        showEventId: Number,
        place: Number,
        row: String,
    },
    data() {
        return {
            isUpdate: this.customerId != null,
            form: this.$inertia
                .form({
                    booking: 1,
                    customer_id: this.customerId,
                    show_event_id: this.$parent.showEventId,
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
                onSuccess: () => this.form.reset(),
            });
        },
        update() {
            this.form.put(this.route("bookings.update", this.form), {
                onSuccess: () => this.form.reset(),
            });
        },
    },
};
</script>
