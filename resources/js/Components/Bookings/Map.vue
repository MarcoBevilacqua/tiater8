<template>
    <div class="grid grid-cols-2 mr-6">
        <div class="col-span-1 center text-left">
            <Row
                :bookedPlaces="getBookedPlacesForRow('X')"
                :places="2"
                :row="'X'"
                @show-modal="modalShow"
            />
        </div>
    </div>
    <div class="grid grid-cols-2 gap-x-6 bg-white-500">
        <div class="col-span-1 left">
            <Row
                :bookedPlaces="getBookedPlacesForRow('A')"
                :places="6"
                :row="'A'"
                @show-modal="modalShow"
            />
            <Row
                :bookedPlaces="getBookedPlacesForRow('B')"
                :places="6"
                :row="'B'"
                @show-modal="modalShow"
            />
            <Row
                :bookedPlaces="getBookedPlacesForRow('C')"
                :places="4"
                :row="'C'"
                @show-modal="modalShow"
            />
            <Row
                :bookedPlaces="getBookedPlacesForRow('D')"
                :places="4"
                :row="'D'"
                @show-modal="modalShow"
            />
            <Row
                :bookedPlaces="getBookedPlacesForRow('E')"
                :places="3"
                :row="'E'"
                @show-modal="modalShow"
            />
            <Row
                :bookedPlaces="getBookedPlacesForRow('F')"
                :places="3"
                :row="'F'"
                @show-modal="modalShow"
            />
            <Row
                :bookedPlaces="getBookedPlacesForRow('G')"
                :places="4"
                :row="'G'"
                @show-modal="modalShow"
            />
            <Row
                :bookedPlaces="getBookedPlacesForRow('H')"
                :places="4"
                :row="'H'"
                @show-modal="modalShow"
            />
        </div>
        <div class="col-span-1 right">
            <Row
                :bookedPlaces="getBookedPlacesForRow('X')"
                :custom="true"
                :places="1"
                :row="'X'"
                @show-modal="modalShow"
            />
            <Row
                :bookedPlaces="getBookedPlacesForRow('I')"
                :places="4"
                :row="'I'"
                @show-modal="modalShow"
            />
            <Row
                :bookedPlaces="getBookedPlacesForRow('L')"
                :places="4"
                :row="'L'"
                @show-modal="modalShow"
            />
            <Row
                :bookedPlaces="getBookedPlacesForRow('Y')"
                :custom="true"
                :places="3"
                :row="'Y'"
                @show-modal="modalShow"
            />

        </div>
    </div>
    <Modal
        v-if="this.showModal"
        :addPlace="this.addPlace"
        :customer="this.customerBooking.customer"
        :place="this.place"
        :row="this.row"
        :showEventId="this.customerBooking.show_event_id"
        @show-modal="showModal"
        @close-modal="modalClose"
    />
</template>

<script>
import Row from "@/Components/Bookings/Row";
import Modal from "@/Components/Bookings/Modal";

export default {
    components: {
        Modal,
        Row,
        CustomRow,
    },
    props: {
        addPlace: Boolean,
        bookings: Object,
        customerBooking: Object,
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
            return this.bookings[row].map((booking) => {
                return {
                    place_number: booking.place_number,
                    customer_id: booking.customer_id,
                };
            });
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
