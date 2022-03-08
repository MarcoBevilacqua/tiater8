<template>
    <div class="grid grid-cols-2 mr-6">
        <div class="col-span-1 center text-left">
            <Row
                @show-modal="modalShow"
                :places="2"
                :row="'X'"
                :bookedPlaces="getBookedPlacesForRow('X')"
            />
        </div>
    </div>
    <div class="grid grid-cols-2 gap-x-6 bg-white-500">
        <div class="col-span-1 left">
            <Row
                @show-modal="modalShow"
                :places="6"
                :row="'A'"
                :bookedPlaces="getBookedPlacesForRow('A')"
            />
            <Row
                @show-modal="modalShow"
                :places="6"
                :row="'B'"
                :bookedPlaces="getBookedPlacesForRow('B')"
            />
            <Row
                @show-modal="modalShow"
                :places="4"
                :row="'C'"
                :bookedPlaces="getBookedPlacesForRow('C')"
            />
            <Row
                @show-modal="modalShow"
                :places="4"
                :row="'D'"
                :bookedPlaces="getBookedPlacesForRow('D')"
            />
            <Row
                @show-modal="modalShow"
                :places="3"
                :row="'E'"
                :bookedPlaces="getBookedPlacesForRow('E')"
            />
            <Row
                @show-modal="modalShow"
                :places="3"
                :row="'F'"
                :bookedPlaces="getBookedPlacesForRow('F')"
            />
            <Row
                @show-modal="modalShow"
                :places="4"
                :row="'G'"
                :bookedPlaces="getBookedPlacesForRow('G')"
            />
            <Row
                @show-modal="modalShow"
                :places="4"
                :row="'H'"
                :bookedPlaces="getBookedPlacesForRow('H')"
            />
        </div>
        <div class="col-span-1 right">
            <CustomRow
                @show-modal="modalShow"
                :places="1"
                :row="'X'"
                :bookedPlaces="getBookedPlacesForRow('X')"
            />
            <Row
                @show-modal="modalShow"
                :places="4"
                :row="'I'"
                :bookedPlaces="getBookedPlacesForRow('I')"
            />
            <Row
                @show-modal="modalShow"
                :places="4"
                :row="'L'"
                :bookedPlaces="getBookedPlacesForRow('L')"
            />
            <CustomRow
                @show-modal="modalShow"
                :places="3"
                :row="'Y'"
                :bookedPlaces="getBookedPlacesForRow('Y')"
            />
        </div>
    </div>
    <Modal
        v-if="this.showModal"
        :showModal="showModal"
        @close-modal="modalClose"
        :booking="booking.id"
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
        booking: Object,
        bookings: Array,
        createLink: String,
        method: String,
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
        getBookedPlacesForRow(row) {
            if (!this.bookings[row]) return [];
            let p = this.bookings[row].map((boo) => {
                return boo.place_number;
            });
            return p;
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
