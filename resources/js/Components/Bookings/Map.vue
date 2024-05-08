<template>
    <div id="printable">
        <small class="print:text-xs screen:hidden mb-2.5">{{ showObj.title }} / {{ showObj.date }}</small>
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

                <div class="print:hidden col-span-1 mx-auto w-full mx-auto p-4 text-left">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-1 bg-yellow-600 w-8 h-4 mt-1 rounded-md"></div>
                        <div class="col-span-10"><p>Posto prenotato</p></div>
                    </div>
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-1 bg-green-600 w-8 h-4 mt-1 rounded-md"></div>
                        <div class="col-span-10"><p>Posto libero</p></div>
                    </div>
                </div>
                <div class="print:hidden grid grid-cols-3 mt-2">
                    <div class="col-start-1"></div>
                    <button
                        onclick="window.print()"
                        class="bg-white mr-4 py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 inline-flex items-center hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span class="pr-2">Stampa Anteprima</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd" d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.155 1.705A1.875 1.875 0 0 0 7.232 22.5h9.536a1.875 1.875 0 0 0 1.867-2.045l-.155-1.705h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM16.5 6.205v-2.83A.375.375 0 0 0 16.125 3h-8.25a.375.375 0 0 0-.375.375v2.83a49.353 49.353 0 0 1 9 0Zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 0 1-.374.409H7.232a.375.375 0 0 1-.374-.409l.526-5.784a.373.373 0 0 1 .333-.337 41.741 41.741 0 0 1 8.566 0Zm.967-3.97a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H18a.75.75 0 0 1-.75-.75V10.5ZM15 9.75a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V10.5a.75.75 0 0 0-.75-.75H15Z" clip-rule="evenodd" />
                        </svg>

                    </button>
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
        showObj: Object,
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
