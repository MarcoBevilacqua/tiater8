<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>
        <template #main>
            <container>
                <div
                    class="flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8"
                >
                    <div class="max-w-md w-full space-y-8">
                        <div>
                            <h2
                                class="mt-6 text-center text-2xl font-extrabold text-gray-900"
                            >
                                Invia Mail di tesseramento
                            </h2>
                        </div>
                        <form class="mt-8 space-y-6" @submit.prevent="submit">
                            <input type="hidden" name="remember" value="true" />
                            <input
                                type="hidden"
                                name="_token"
                                v-bind:value="token"
                            />
                            <div class="rounded-md shadow-sm -space-y-px">
                                <div>
                                    <label for="customer_email" class="sr-only"
                                        >Email address</label
                                    >
                                    <input
                                        v-model="form.customer_email"
                                        id="customer_email"
                                        name="customer_email"
                                        type="email"
                                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                        placeholder="Inserisci indirizzo mail"
                                    />
                                </div>
                            </div>
                            <div v-if="!form.processing">
                                <button
                                    type="submit"
                                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    <span
                                        class="absolute left-0 inset-y-0 flex items-center pl-3"
                                    >
                                    </span>
                                    Invita
                                </button>
                            </div>
                            <div v-else>
                                <button
                                    type="button"
                                    class="group relative w-full flex justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-400 hover:bg-indigo-600 transition ease-in-out duration-150 cursor-not-allowed"
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
                            <div
                                v-if="form.errors.customer_email"
                                class="rounded-md shadow-sm font-semibold bg-red-200 text-red-600 text-sm p-4"
                            >
                                <span>{{ form.errors.customer_email }}</span>
                            </div>
                        </form>
                    </div>
                </div>
            </container>
        </template>
    </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import Container from "@/Layouts/Container";
import { useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

export default {
    components: {
        BreezeAuthenticatedLayout,
        Container,
    },

    setup() {
        const form = useForm({
            customer_email: null,
        });

        function submit() {
            form.post("/subscriptions/init", {
                preserveScroll: true,
                onSuccess: () => form.reset("customer_email"),
            });
        }

        return { form, submit };
    },

    props: {
        errors: Object,
        token: String,
        form_url: String,
    },
};
</script>
