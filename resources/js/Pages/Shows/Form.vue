<template>
    <breeze-authenticated-layout>
        <template #header>
            <h1>Modifica "{{ show.name }}"</h1>
        </template>
        <template #main>
            <container>
                <div class="mt-10 sm:mt-5">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="mt-10 md:mt-5 md:col-span-3">
                            <form @submit.prevent="update">
                                <div
                                    class="shadow overflow-hidden sm:rounded-md"
                                >
                                    <div class="px-4 py-5 bg-white sm:p-6">
                                        <input
                                            type="hidden"
                                            v-model="form.id"
                                            name="id"
                                            id="id"
                                        />
                                        <div class="grid grid-cols-8 gap-6">
                                            <div
                                                class="mx-auto sm:col-span-4 col-span-4"
                                            >
                                                <div v-if="form.image">
                                                    <img
                                                        width="400"
                                                        height="600"
                                                        :src="form.image"
                                                        class="rounded"
                                                    />
                                                </div>
                                                <label
                                                    for="image"
                                                    class="block text-sm font-medium text-gray-700"
                                                    >Immagine</label
                                                >
                                                <input
                                                    type="file"
                                                    @input="
                                                        form.image =
                                                            $event.target.files[0]
                                                    "
                                                />
                                                <div v-if="errors.image">
                                                    {{ errors.image }}
                                                </div>
                                            </div>

                                            <div
                                                class="sm:col-span-4 col-span-4"
                                            >
                                                <div
                                                    class="sm:col-span-6 col-span-3"
                                                >
                                                    <label
                                                        for="title"
                                                        class="block text-sm font-medium text-gray-700"
                                                        >Titolo</label
                                                    >
                                                    <input
                                                        v-model="form.title"
                                                        type="text"
                                                        name="title"
                                                        id="title"
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                    />
                                                    <div v-if="errors.title">
                                                        {{ errors.title }}
                                                    </div>
                                                </div>
                                                <div
                                                    class="sm:col-span-6 col-span-3 py-5"
                                                >
                                                    <label
                                                        for="url"
                                                        class="block text-sm font-medium text-gray-700"
                                                        >Url</label
                                                    >
                                                    <input
                                                        v-model="form.url"
                                                        type="text"
                                                        name="url"
                                                        id="url"
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                    />
                                                    <div v-if="errors.url">
                                                        {{ errors.url }}
                                                    </div>
                                                </div>

                                                <div
                                                    class="sm:col-span-6 col-span-3 py-5"
                                                >
                                                    <label
                                                        for="description"
                                                        class="block text-sm font-medium text-gray-700"
                                                        >Descrizione</label
                                                    >
                                                    <textarea
                                                        v-model="
                                                            form.description
                                                        "
                                                        name="description"
                                                        id="description"
                                                        rows="12"
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                    >
                                                    </textarea>
                                                    <div
                                                        v-if="
                                                            errors.description
                                                        "
                                                    >
                                                        {{ errors.description }}
                                                    </div>
                                                </div>
                                                <div
                                                    class="grid grid-cols-4 gap-4"
                                                >
                                                    <div
                                                        class="sm:col-span-2 col-span-2 py-5"
                                                    >
                                                        <label
                                                            for="full_price"
                                                            class="block text-sm font-medium text-gray-700"
                                                            >Prezzo pieno</label
                                                        >
                                                        <input
                                                            v-model="
                                                                form.full_price
                                                            "
                                                            type="number"
                                                            name="full_price"
                                                            id="full_price"
                                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                        />
                                                    </div>
                                                    <div
                                                        class="sm:col-span-2 col-span-2 py-5"
                                                    >
                                                        <label
                                                            for="half_price"
                                                            class="block text-sm font-medium text-gray-700"
                                                            >Prezzo
                                                            ridotto</label
                                                        >
                                                        <input
                                                            v-model="
                                                                form.half_price
                                                            "
                                                            name="half_price"
                                                            id="half_price"
                                                            type="number"
                                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                        />
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
                                                @click="delete"
                                                type="button"
                                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                            >
                                                Cancella
                                            </button>
                                        </div>
                                        <div
                                            class="grid-col-span-1px-4 py-3 bg-gray-50 text-right sm:px-6"
                                        >
                                            <a
                                                :href="route('shows.index')"
                                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-400 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-4"
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
import { useForm } from "@inertiajs/inertia-vue3";
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Container,
        BreezeAuthenticatedLayout,
    },

    props: {
        errors: Object,
        show: Array,
        _method: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                _method: this._method,
                id: this.show.id,
                title: this.show.title,
                description: this.show.description,
                image: this.show.image,
                url: this.show.url,
                half_price: this.show.half_price,
                full_price: this.show.full_price,
            }),
        };
    },

    methods: {
        update() {
            this.form.post(this.route("shows.update", this.show.id), {
                onSuccess: () => this.form.reset(),
            });
        },
        delete() {
            this.form.delete(this.route("shows.destroy", this.show));
        },
    },
};
</script>
