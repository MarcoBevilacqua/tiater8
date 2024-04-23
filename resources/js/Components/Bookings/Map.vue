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
    <pre>{{this.selectedBooking}}</pre>
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
                :bookedPlaces="getBookedPlacesForRow('Y')"
                :custom="true"
                :places="2"
                :row="'Y'"
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
                :bookedPlaces="getBookedPlacesForRow('Z')"
                :custom="true"
                :places="3"
                :row="'Z'"
                @show-modal="modalShow"
            />

            <div class="col-span-1 mx-auto w-full mx-auto p-4 text-left">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-1 bg-yellow-600 w-8 h-4 mt-1 rounded-md"></div>
                    <div class="col-span-10"><p>Posto prenotato</p></div>
                </div>
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-1 bg-green-600 w-8 h-4 mt-1 rounded-md"></div>
                    <div class="col-span-10"><p>Posto libero</p></div>
                </div>
            </div>
        </div>
    </div>

    <transition>
    <Modal
        v-if="this.showModal"
        :booking="this.selectedBooking"
        :showEventId="this.showEventId"
        @show-modal="showModal"
        @close-modal="modalClose"
    />
    </transition>
</template>

<style>
.v-enter-active,
.v-leave-active {
    transition: opacity 0.3s ease-out;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}
</style>

<script>
import Row from "@/Components/Bookings/Row";
import Modal from "@/Components/Bookings/Modal";

export default {
    components: {
        Modal,
        Row
    },
    props: {
        bookings: Object,
        showEventId: Number,
    },
    methods: {
        modalShow(row, place) {
            let customer = this.bookings[row]?.filter(obj => {
                return obj.place_number === place
            })[0]
            this.selectedBooking = {
                place_number: place,
                row_letter: row,
                ...customer
            }
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
                return {place_number: booking.place_number}
            });
        },
    },
    data() {
        return {
            show:false,
            showModal: false,
            place: null,
            row: null,
            selectedBooking: null
        };
    },
};
</script>
