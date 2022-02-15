<template>
    <div class="grid grid-cols-2">
        <div class="col-span-1 center text-left">
            <Row :places="2" :row="'X'" />
        </div>
    </div>
    <div class="grid gap-x-2 grid-cols-2 bg-white-500">
        <div class="col-span-1 left">
            <Row @show-modal="this.showModal = true" :places="6" :row="'A'" />
            <Row @show-modal="this.showModal = true" :places="6" :row="'B'" />
            <Row @show-modal="this.showModal = true" :places="4" :row="'C'" />
            <Row @show-modal="this.showModal = true" :places="4" :row="'D'" />
            <Row @show-modal="this.showModal = true" :places="3" :row="'E'" />
            <Row @show-modal="this.showModal = true" :places="3" :row="'F'" />
            <Row @show-modal="this.showModal = true" :places="4" :row="'G'" />
            <Row @show-modal="this.showModal = true" :places="4" :row="'H'" />
        </div>
        <div class="col-span-1 right">
            <Row :places="4" :row="'I'" />
            <Row :places="4" :row="'L'" />
        </div>
    </div>
    <Modal :showModal="showModal" @close-modal="showModal = false" />
</template>

<script>
import Row from "@/Components/Bookings/Row";
import Modal from "@/Components/Bookings/Modal";

export default {
    components: {
        Modal,
        Row,
    },
    props: {
        bookings: Object,
        createLink: String,
    },
    data() {
        return {
            showModal: false,
        };
    },
};
</script>
