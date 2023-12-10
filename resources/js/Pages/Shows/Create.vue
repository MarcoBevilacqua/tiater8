<template>
    <breeze-authenticated-layout>
        <template #header>
            <h1>Inserisci Spettacolo</h1>
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
                                                <div v-if="form.image">
                                                    <img
                                                        v-if="showurl"
                                                        :src="showurl"
                                                        class="w-full mt-4"
                                                        height="800"
                                                        width="600"
                                                    />
                                                </div>
                                                <label
                                                    class="block text-sm font-medium text-gray-700"
                                                    for="image"
                                                >Immagine</label
                                                >
                                                <input
                                                    ref="photo"
                                                    type="file"
                                                    @change="previewImage"
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
                                                class="sm:col-span-3 col-span-3"
                                            >
                                                <div
                                                    class="sm:col-span-6 col-span-3"
                                                >
                                                    <label
                                                        class="block text-sm font-medium text-gray-700"
                                                        for="name"
                                                    >Titolo*</label
                                                    >
                                                    <input
                                                        id="title"
                                                        v-model="form.title"
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                        name="title"
                                                        type="text"
                                                        :class="[errors.title ? 'border-red-400' : '']"
                                                    />
                                                    <div v-if="errors.title" class="text-red-400 pt-2.5">
                                                        {{ errors.title }}
                                                    </div>
                                                </div>
                                                <div
                                                    class="sm:col-span-6 col-span-3 py-5"
                                                >
                                                    <label
                                                        class="block text-sm font-medium text-gray-700"
                                                        for="url"
                                                    >Url</label
                                                    >
                                                    <input
                                                        id="url"
                                                        v-model="form.url"
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                        name="url"
                                                        type="text"
                                                    />
                                                    <div v-if="errors.url">
                                                        {{ errors.url }}
                                                    </div>
                                                </div>

                                                <div
                                                    class="sm:col-span-6 col-span-3 py-5"
                                                >
                                                    <label
                                                        class="block text-sm font-medium text-gray-700"
                                                        for="description"
                                                    >Descrizione</label
                                                    >
                                                    <textarea
                                                        id="description"
                                                        v-model="
                                                            form.description
                                                        "
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                        name="description"
                                                        rows="12"
                                                    >
                                                    </textarea>
                                                </div>
                                                <div
                                                    class="grid grid-cols-4 gap-4"
                                                >
                                                    <div
                                                        class="sm:col-span-2 col-span-2 py-5"
                                                    >
                                                        <label
                                                            class="block text-sm font-medium text-gray-700"
                                                            for="full_price"
                                                        >Prezzo pieno*</label
                                                        >
                                                        <input
                                                            id="full_price"
                                                            v-model="
                                                                form.full_price
                                                            "
                                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                            name="full_price"
                                                            type="number"
                                                        />
                                                        <div v-if="errors.full_price" class="text-red-400 pt-2.5" :class="[errors.full_price ? 'border-red-400' : '']">
                                                            {{errors.full_price}}
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="sm:col-span-2 col-span-2 py-5"
                                                    >
                                                        <label
                                                            class="block text-sm font-medium text-gray-700"
                                                            for="half_price"
                                                        >Prezzo
                                                            ridotto</label
                                                        >
                                                        <input
                                                            id="half_price"
                                                            v-model="
                                                                form.half_price
                                                            "
                                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                            name="half_price"
                                                            type="number"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="px-4 py-3 bg-gray-50 text-right sm:px-6"
                                    >
                                        <a
                                            :href="route('subscriptions.index')"
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
        _method: String,
    },

    data() {
        return {
            showurl: null,
            form: this.$inertia.form({
                title: null,
                description: null,
                image: null,
                url: null,
                _method: this._method,
            }),
        };
    },

    methods: {
        create() {
            if (this.$refs.photo) {
                this.form.image = this.$refs.photo.files[0];
            }
            this.form.post(this.route("shows.store", this.form), {
                onSuccess: () => this.form.reset(),
            });
        },
        previewImage(e) {
            const file = e.target.files[0];
            this.showurl = URL.createObjectURL(file);
        },
    },
};
</script>
