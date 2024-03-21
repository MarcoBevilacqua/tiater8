<template>
    <div class="relative">
        <label
            class="block text-sm font-medium text-gray-700"
            for="search">Nominativo</label>
        <input
            v-model="customer"
            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
            minlength="3"
            placeholder="Cerca un iscritto con nome o cognome..."
            required
            type="search"
            @input="visit"
            @search="manageSearchInput"
        />

        <div  class="w-full absolute left-0 bg-white">
            <div v-if="searching" class="flex w-full justify-center bg-gray-300 p-5 rounded-b-md border-b-2 text-center">
                <spinner :size="5" :color="'gray'"></spinner>
            </div>
            <div v-else>
                <ul v-if="suggestions.length" class="bg-gray-100">
                    <li v-for="suggestion in this.suggestions"
                        class="text-sm font-semibold cursor-pointer hover:bg-gray-200 px-2 py-2 rounded-b-md border-b-2 border-r-2 border-l-2"
                        @click="this.selectCustomer(suggestion.id, suggestion.name)">
                        {{ suggestion.name }}
                    </li>
                </ul>
            </div>
        </div>
        <div v-if="this.noResults">
            <ul>
                <li class="text-sm text-red-700 px-2 py-2 border-red-500 rounded-b-md border-b-2 border-r-2 border-l-2">
                    Nessun risultato
                </li>
            </ul>
        </div>
    </div>
</template>

<script>

import throttle from "lodash/throttle";
import axios from "axios";
import Spinner from "@/Shared/Spinner.vue";

export default {
    name: "CustomerAutocomplete",
    components: {Spinner},

    props: {
        customerProp: Object
    },

    data() {
        return {
            suggestions: [],
            search: "",
            customer: "",
            noResults: false,
            searching: false,
        }
    },
    methods: {
        resetSearchData() {
            this.suggestions = []
            this.noResults = false
            this.searching = false
        },
        manageSearchInput(e) {
            //manage search event
            if (e.target.value.length === 0) this.resetSearchData()
        },
        debounceVisit() {
            throttle(function (e) {
                this.visit(e)
            }, 250)
        },
        visit(e) {
            this.searching = true;
            let term = e.target.value;
            if (term.length < 3) {
                this.resetSearchData()
                return;
            }

            this.debounceVisit(e)
            console.log(`Searching for ${term}...`)
            axios.get(
                "/api/customers",
                {params: {term: term}},
            ).then(res => {
                if (res.data.length === 0) {
                    this.suggestions = []
                    this.searching = false
                    this.noResults = true //show message if no user is retrieved
                    return
                }
                this.noResults = false
                this.suggestions = res.data
                this.searching = false
            }).catch(err => {
                console.log(err)
            });
        },
        selectCustomer(customerId, name) {
            console.log(customerId)
            this.$emit('customer-selected', customerId)
            this.customer = name
            this.suggestions = [];
        },
        removeAll() {
            this.noResults = false
        }
    },
    mounted() {
        this.customer = this.customerProp
    }
}
</script>
