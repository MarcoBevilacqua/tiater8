<template>
    <breeze-authenticated-layout>
        <template #header>
            <h1>Inserisci Data</h1>
        </template>
        <template #main>
            <container>
                <div class="mt-10 sm:mt-5">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="mt-10 md:mt-5 md:col-span-3">
                            <form @submit.prevent="create">
                                <div
                                    class="shadow overflow-hidden sm:rounded-md"
                                >
                                    <div class="px-4 py-5 bg-white sm:p-6">
                                        <div class="grid grid-cols-6 gap-6">
                                            <div
                                                class="sm:col-span-3 col-span-3"
                                            >
                                                <div
                                                    class="sm:col-span-6 col-span-3"
                                                >
                                                    <label
                                                        class="block text-sm font-medium text-gray-700"
                                                        for="name"
                                                    >Data</label
                                                    >
                                                    <input
                                                        id="show_date"
                                                        v-model="form.show_date"
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                        name="show_date"
                                                        type="date"
                                                    />
                                                    <div
                                                        v-if="errors.show_date"
                                                    >
                                                        {{ errors.show_date }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="sm:col-span-3 col-span-3"
                                            >
                                                <div
                                                    class="sm:col-span-6 col-span-3"
                                                >
                                                    <label
                                                        class="block text-sm font-medium text-gray-700"
                                                        for="name"
                                                    >Orario</label
                                                    >
                                                    <select
                                                        id="customer"
                                                        v-model="
                                                            form.show_date_time
                                                        "
                                                        class="w-full mt-1 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                        name="customer"
                                                    >
                                                        <option
                                                            v-for="available_time in available_times"
                                                            :key="
                                                                available_time
                                                            "
                                                            :value="
                                                                available_time
                                                            "
                                                        >{{
                                                                available_time
                                                            }}
                                                        </option
                                                        >
                                                    </select>
                                                    <div
                                                        v-if="
                                                            errors.show_date_time
                                                        "
                                                    >
                                                        {{
                                                            errors.show_date_time
                                                        }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="px-4 py-3 bg-gray-50 text-right sm:px-6"
                                    >
                                        <a
                                            :href="
                                                route('show-events.index', {
                                                    show: show_id,
                                                })
                                            "
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-400 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 mr-3"
                                        >
                                            Torna alla lista
                                        </a>
                                        <button
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                            type="submit"
                                        >
                                            Salva
                                        </button>
                                    </div>
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

export default {
    components: {
        Container,
        BreezeAuthenticatedLayout,
    },

    props: {
        errors: Object,
        show_id: Number,
        available_times: Array,
        show: Number,
        _method: String,
    },

    data() {
        return {
            form: this.$inertia
                .form({
                    show_date: null,
                    show_date_time: null,
                    _method: this._method,
                })
                .transform((data) => ({
                    ...data,
                    show_id: this.$props.show_id,
                })),
        };
    },

    methods: {
        create() {
            this.form.post(this.route("show-events.store", this.form), {
                onSuccess: () => this.form.reset(),
            });
        },
    },
};
</script>
