<template>
    <breeze-authenticated-layout>
        <template #header>
            <h1>Inserisci Data per "{{ show_event.show_title }}"</h1>
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
                                    <input
                                        type="hidden"
                                        name="id"
                                        v-model="show_event.id"
                                    />
                                    <div class="px-4 py-5 bg-white sm:p-6">
                                        <div class="grid grid-cols-6 gap-6">
                                            <div
                                                class="sm:col-span-3 col-span-3"
                                            >
                                                <div
                                                    class="sm:col-span-6 col-span-3"
                                                >
                                                    <label
                                                        for="name"
                                                        class="block text-sm font-medium text-gray-700"
                                                        >Data</label
                                                    >
                                                    <input
                                                        v-model="form.show_date"
                                                        type="date"
                                                        name="show_date"
                                                        id="show_date"
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
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
                                                        for="name"
                                                        class="block text-sm font-medium text-gray-700"
                                                        >Orario</label
                                                    >
                                                    <select
                                                        class="w-full mt-1 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                        name="customer"
                                                        id="customer"
                                                        v-model="
                                                            form.show_date_time
                                                        "
                                                    >
                                                        <option
                                                            v-for="available_time in available_times"
                                                            :selected="
                                                                form.show_date_time
                                                            "
                                                            :key="
                                                                available_time
                                                            "
                                                            :value="
                                                                available_time
                                                            "
                                                            >{{
                                                                available_time
                                                            }}</option
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
                                    <div class="grid grid-cols-2">
                                        <div
                                            class="grid-col-span-1 px-4 py-3 bg-gray-50 text-left sm:px-6"
                                        >
                                            <button
                                                @click="this.delete"
                                                type="button"
                                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                            >
                                                Cancella
                                            </button>
                                        </div>
                                        <div
                                            class="grid-col-span-1 px-4 py-3 bg-gray-50 text-right sm:px-6"
                                        >
                                            <a
                                                :href="
                                                    route('show-events.index', {
                                                        show:
                                                            show_event.show_id,
                                                    })
                                                "
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
        show_event: Object,
        available_times: Array,
        _method: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                id: this.show_event.id,
                show_date: this.show_event.show_date,
                show_date_time: this.show_event.show_date_time,
                _method: this._method,
            }),
        };
    },

    methods: {
        create() {
            this.form.put(this.route("show-events.update", this.show_event), {
                onSuccess: () => this.form.reset(),
            });
        },
        delete() {
            this.form.delete(
                this.route("show-events.destroy", this.show_event),
                {
                    onSuccess: () => this.form.reset(),
                }
            );
        },
    },
};
</script>
