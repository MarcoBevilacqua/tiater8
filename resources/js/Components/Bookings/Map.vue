<template>
    <div class="grid grid-cols-2 mr-6">
        <div class="col-span-1 center text-left">
            <Row @show-modal="modalShow" :places="2" :row="'X'" />
        </div>
    </div>
    <div class="grid grid-cols-2 gap-x-6 bg-white-500">
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
            <CustomRow @show-modal="modalShow" :places="1" :row="'X'" />
            <Row @show-modal="modalShow" :places="4" :row="'I'" />
            <Row @show-modal="modalShow" :places="4" :row="'L'" />
            <CustomRow @show-modal="modalShow" :places="3" :row="'Y'" />
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
import CustomRow from "@/Components/Bookings/CustomRow";
import Modal from "@/Components/Bookings/Modal";

export default {
    components: {
        Modal,
        Row,
        CustomRow,
    },
    props: {
        createLink: String,
    },
    methods: {
        modalShow(row, place) {
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
