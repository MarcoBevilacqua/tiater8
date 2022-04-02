<template>
    <div
        class="md:col-start-3 md:col-span-4 sm:col-span-3 mb-4"
    >
        <label
            class="block text-sm font-medium text-gray-700"
            for="customer_id"
        >Selezionare nominativo:</label
        >
        <select
            id="customer_id"
            v-model="form.customer_id"
            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
            name="customer_id"
            required
        >
            <option
                v-for="customer in customers"
                :value="customer.id"
            >{{ customer.name }}
            </option>
        </select>
    </div>
</template>

<script>
export default {
    name: "CustomerAutocomplete",
    props: {customers: Array},
}
</script>
