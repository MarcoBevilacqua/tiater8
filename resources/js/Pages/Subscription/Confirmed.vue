<template>
    <guest>
        <div class="flex justify-items-center">
            <div class="w-full">
                <img
                    class="mx-auto rounded-md"
                    :src="'/img/common/logo.jpg'"
                    alt="pci_logo"
                />
            </div>
        </div>
        <div class="text-center">
            <h2>Operazione completata con successo!</h2>
        </div>
    </guest>
</template>

<script>
import Container from "@/Layouts/Container";
import Guest from "@/Layouts/Guest";

export default {
    components: {
        Container,
        Guest,
    },

    props: {},
};
</script>
