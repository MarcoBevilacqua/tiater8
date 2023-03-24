<template>
    <div class="relative">
        <label
            class="block text-sm font-medium text-gray-700"
            for="search">Selezionare nominativo:</label>
        <input
            v-model="customer"
            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
            placeholder="Cerca un iscritto con nome o cognome..."
            type="search"
            @input="visit"
        />

        <div v-if="suggestions.length" class="w-full absolute left-0 bg-white" @focusout="">
            <ul>
                <li v-for="suggestion in this.suggestions"
                    class="text-sm cursor-pointer text-gray-400 hover:bg-gray-100 px-2 py-1 border-b-2 border-r-2 border-l-2"
                    @click="this.selectCustomer(suggestion.id, suggestion.name)">
                    {{ suggestion.name }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>

import throttle from "lodash/throttle";
import axios from "axios";

export default {
    name: "CustomerAutocomplete",

    data() {
        return {
            suggestions: [],
            search: "",
            customer: ""
        }
    },
    methods: {
        debounceVisit() {
            throttle(function (e) {
                this.visit(e)
            }, 250)
        },
        visit(e) {
            let term = e.target.value;
            if (term.length < 3) return;

            this.debounceVisit(e)
            console.log("Searching for " + term + "...")
            axios.get(
                "/api/customers",
                {params: {term: term}},
            ).then(res => {
                this.suggestions = res.data
            }).catch(err => {
                console.log(err)
            });
        },
        selectCustomer(customerId, name) {
            console.log(customerId)
            this.$emit('customer-selected', customerId)
            this.customer = name
            this.suggestions = [];
        }
    },
}
</script>
