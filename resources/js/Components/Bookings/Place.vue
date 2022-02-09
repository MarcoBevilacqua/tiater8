<template>
    <div class="col-span-1">
        <div class="bg-green-400 rounded">
            <span>Posto numero: {{ idx }} fila {{ row }}</span>
        </div>
    </div></template
>

<script>
export default {
    props: {
        row: String,
        idx: Number,
    },
};
</script>
