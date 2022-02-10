<template #guest>
    <container>
        <div class="mt-5 md:mt-10 lg:mt-10 md:px-12 lg:px-24">
            <div class="flex justify-items-center">
                <div class="w-full">
                    <img
                        class="mx-auto rounded-md"
                        :src="'/img/common/logo.jpg'"
                        alt="pci_logo"
                        width="120"
                        height="80"
                    />
                </div>
            </div>
            <div class="grid grid-cols-3 md:grid md:grid-cols-3 md:gap-6">
                <div class="col-span-3 mt-10 md:mt-5 md:col-span-3 text-center">
                    <h2
                        class="mt-6 text-center text-2xl xs:text-sm font-extrabold text-gray-900"
                    >
                        Ciao, inserisci la tua mail!
                    </h2>
                    <small
                        >Sarai reindirizzato al form di completamento
                        dati</small
                    >
                </div>
                <div
                    class="col-span-3 mx-8 md:col-start-2 md:col-span-1 md:mx-2"
                >
                    <form class="mt-4 space-y-6" @submit.prevent="submit">
                        <input type="hidden" name="remember" value="true" />
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
                                    class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm text-center"
                                    placeholder="Il tuo indirizzo mail"
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
                                Conferma
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
                            v-if="errors.customer_email"
                            class="text-center rounded-md shadow-sm font-semibold bg-red-200 text-red-600 text-sm p-2"
                        >
                            <span>{{ errors.customer_email }}</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </container>
</template>

<script>
import Container from "@/Layouts/Container";
import { useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

export default {
    components: {
        Container,
    },

    setup() {
        const form = useForm({
            customer_email: null,
        });

        function submit() {
            form.post("/over/subscriptions/init", {
                preserveScroll: true,
                onSuccess: () => form.reset("customer_email"),
                onError: () => form.reset("customer_email"),
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
