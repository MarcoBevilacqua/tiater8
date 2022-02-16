<template>
    <div class="grid grid-cols-2">
        <div class="col-span-1 center text-left">
            <Row @show-modal="modalShow" :places="2" :row="'X'" />
        </div>
    </div>
    <div class="grid gap-x-2 grid-cols-2 bg-white-500">
        <div class="col-span-1 left">
            <Row @show-modal="modalShow" :places="6" :row="'A'" />
            <Row @show-modal="modalShow" :places="6" :row="'B'" />
            <Row @show-modal="modalShow" :places="4" :row="'C'" />
            <Row @show-modal="modalShow" :places="4" :row="'D'" />
            <Row @show-modal="modalShow" :places="3" :row="'E'" />
            <Row @show-modal="modalShow" :places="3" :row="'F'" />
            <Row @show-modal="modalShow" :places="4" :row="'G'" />
            <Row @show-modal="modalShow" :places="4" :row="'H'" />
        </div>
        <div class="col-span-1 right">
            <Row @show-modal="modalShow" :places="4" :row="'I'" />
            <Row @show-modal="modalShow" :places="4" :row="'L'" />
        </div>
    </div>
    <Modal
        :showModal="showModal"
        @close-modal="modalClose"
        :place="this.place"
        :row="this.row"
    />
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
        customers: Object,
        createLink: String,
    },
    methods: {
        modalShow(row, place) {
            console.log("AAAAA");
            this.place = place;
            this.row = row;
            this.showModal = true;
        },
        modalClose() {
            this.place = null;
            this.row = null;
            this.showModal = false;
        },
    },
    data() {
        return {
            showModal: false,
            place: null,
            row: null,
        };
    },
};
</script>
