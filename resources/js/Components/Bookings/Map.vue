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
        @show-modal="showModal"
        @close-modal="modalClose"
        :customerList="customers"
        :customerId="this.customer?.id"
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
        bookings: Object,
        customers: Object,
        showEventId: Number,
        createLink: String,
        method: String,
    },
    methods: {
        modalShow(row, place, customer) {
            this.place = place;
            this.row = row;
            this.customer = this.customers[customer];
            this.showModal = true;
        },
        modalClose() {
            this.place = null;
            this.row = null;
            this.showModal = false;
        },
        getBookedPlacesForRow(row) {
            if (!this.bookings[row]) return [];
            let p = this.bookings[row].map((booking) => {
                return {
                    place_number: booking.place_number,
                    customer_id: booking.customer_id,
                };
            });
            return p;
        },
    },
    data() {
        return {
            showModal: false,
            customer: null,
            place: null,
            row: null,
        };
    },
};
</script>
