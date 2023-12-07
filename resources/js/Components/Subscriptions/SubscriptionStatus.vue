

<template>
    <div
        class="text-sm font-medium text-gray-900 rounded-md">
        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-inset"
            :class="color">
            {{status.label}}
        </span>
        <span class="px-3 py-4"></span>
    </div>
</template>

<style scoped>

</style>

<script>

export default {
    props: {
        status: Object
    },

    data() {
        return {
            color: "",
            availableColors: {
                //const PENDING = 0;
                0: 'bg-gray-150 text-gray-800 ring-gray 600/20',
                //const TO_BE_COMPLETED = 1;
                1: 'bg-indigo-100 text-indigo-800 ring-indigo 600/20',
                //const TO_BE_CONFIRMED = 2;
                2: 'bg-indigo-100 text-indigo-800 ring-indigo 600/20',
                //const ACTIVE = 3;
                3: 'bg-green-100 text-green-800 ring-green 700/20',
                //const INACTIVE = 4;
                4: 'bg-indigo-50 text-indigo-800 ring-indigo 600/20',
                //const EXPIRED = 5;
                5: 'bg-red-200 text-red-700 ring-red-600/10'
            }
        }
    },
    mounted() {
        Object.entries(this.availableColors).forEach(v => {
            if(parseInt(v[0]) === this.status.value) {
                this.color = v[1];
                return;
            }
        });
    }
}

</script>
