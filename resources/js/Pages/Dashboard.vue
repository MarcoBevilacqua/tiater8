<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h4 class="font-semibold text-lg tracking-wide">
                            Genera Tessera socio
                        </h4>
                        <p class="text-gray-500 my-1">
                            Da qui puoi inviare una mail di invito al
                            tesseramento. Il link scadrà dopo 48h
                        </p>
                        <inertia-link
                            :href="generateLink"
                            class="text-blue-700 inline-flex items-center font-semibold tracking-wide"
                        >
                            <span class="hover:underline">
                                Invia una richiesta di tesseramento
                            </span>
                            <span class="text-xl ml-2">&#8594;</span>
                        </inertia-link>
                    </div>
                </div>
            </div>
        </div>
    </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";

export default {
    components: {
        BreezeAuthenticatedLayout,
    },
    props: {
        generateLink: String,
    },
};
</script>
