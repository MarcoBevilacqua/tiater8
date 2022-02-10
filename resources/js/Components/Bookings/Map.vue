<template>
    <div class="grid grid-cols-2">
        <div class="col-span-1 center text-left">
            <Row :places="2" :row="'A'" />
        </div>
    </div>
    <div class="grid gap-x-2 grid-cols-2 bg-white-500">
        <div class="col-span-1 left">
            <Row :places="6" :row="'A'" />
            <Row :places="6" :row="'B'" />
            <Row :places="4" :row="'C'" />
            <Row :places="4" :row="'D'" />
            <Row :places="3" :row="'E'" />
            <Row :places="3" :row="'F'" />
            <Row :places="4" :row="'G'" />
            <Row :places="4" :row="'H'" />
        </div>
        <div class="col-span-1 right">
            <Row :places="4" :row="'I'" />
            <Row :places="4" :row="'L'" />
        </div>
    </div>
</template>

<script>
import Row from "@/Components/Bookings/Row";

export default {
    components: {
        Row,
    },
    props: {
        bookings: Object,
        createLink: String,
    },
};
</script>
