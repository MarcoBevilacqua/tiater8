<template>
  <breeze-authenticated-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Users</h2>
    </template>
    <container>
      <div class="mt-10 sm:mt-5 px-24">
        <div class="md:grid md:grid-cols-3 md:gap-6">
          <div class="mt-10 md:mt-5 md:col-span-3">
            <form @submit.prevent="submit">
              <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-3 bg-gray-50 text-center sm:px-6">
                  <p>Completa la tua iscrizione</p>
                </div>
                <div class="px-4 py-5 bg-white sm:p-6">
                  <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-4 sm:col-span-2">
                      <label
                        for="first_name"
                        class="block text-sm font-medium text-gray-700"
                        >First name</label
                      >
                      <input
                        type="text"
                        name="first_name"
                        id="first_name"
                        autocomplete="given-name"
                        class="
                          mt-1
                          focus:ring-indigo-500
                          focus:border-indigo-500
                          block
                          w-full
                          shadow-sm
                          sm:text-sm
                          border-gray-300
                          rounded-md
                        "
                      />
                    </div>

                    <div class="col-span-8 sm:col-span-4">
                      <label
                        for="last_name"
                        class="block text-sm font-medium text-gray-700"
                        >Last name</label
                      >
                      <input
                        type="text"
                        name="last_name"
                        id="last_name"
                        autocomplete="family-name"
                        class="
                          mt-1
                          focus:ring-indigo-500
                          focus:border-indigo-500
                          block
                          w-full
                          shadow-sm
                          sm:text-sm
                          border-gray-300
                          rounded-md
                        "
                      />
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                      <label
                        for="email_address"
                        class="block text-sm font-medium text-gray-700"
                        >Email address</label
                      >
                      <input
                        type="text"
                        name="email_address"
                        id="email_address"
                        autocomplete="email"
                        class="
                          mt-1
                          focus:ring-indigo-500
                          focus:border-indigo-500
                          block
                          w-full
                          shadow-sm
                          sm:text-sm
                          border-gray-300
                          rounded-md
                        "
                      />
                    </div>

                    <div class="col-span-4 sm:col-span-2">
                      <label
                        for="street_address"
                        class="block text-sm font-medium text-gray-700"
                        >Street address</label
                      >
                      <input
                        type="text"
                        name="street_address"
                        id="street_address"
                        autocomplete="street-address"
                        class="
                          mt-1
                          focus:ring-indigo-500
                          focus:border-indigo-500
                          block
                          w-full
                          shadow-sm
                          sm:text-sm
                          border-gray-300
                          rounded-md
                        "
                      />
                    </div>

                    <div class="col-span-3 sm:col-span-2">
                      <label
                        for="city"
                        class="block text-sm font-medium text-gray-700"
                        >City</label
                      >
                      <input
                        type="text"
                        name="city"
                        id="city"
                        class="
                          mt-1
                          focus:ring-indigo-500
                          focus:border-indigo-500
                          block
                          w-full
                          shadow-sm
                          sm:text-sm
                          border-gray-300
                          rounded-md
                        "
                      />
                    </div>

                    <div class="col-span-1 sm:col-span-1 lg:col-span-1">
                      <label
                        for="state"
                        class="block text-sm font-medium text-gray-700"
                        >State / Province</label
                      >
                      <input
                        type="text"
                        name="state"
                        id="state"
                        class="
                          mt-1
                          focus:ring-indigo-500
                          focus:border-indigo-500
                          block
                          w-full
                          shadow-sm
                          sm:text-sm
                          border-gray-300
                          rounded-md
                        "
                      />
                    </div>

                    <div class="col-span-1 sm:col-span-1 lg:col-span-1">
                      <label
                        for="postal_code"
                        class="block text-sm font-medium text-gray-700"
                        >ZIP / Postal</label
                      >
                      <input
                        type="text"
                        name="postal_code"
                        id="postal_code"
                        autocomplete="postal-code"
                        class="
                          mt-1
                          focus:ring-indigo-500
                          focus:border-indigo-500
                          block
                          w-full
                          shadow-sm
                          sm:text-sm
                          border-gray-300
                          rounded-md
                        "
                      />
                    </div>
                  </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                  <button
                    type="submit"
                    class="
                      inline-flex
                      justify-center
                      py-2
                      px-4
                      border border-transparent
                      shadow-sm
                      text-sm
                      font-medium
                      rounded-md
                      text-white
                      bg-indigo-600
                      hover:bg-indigo-700
                      focus:outline-none
                      focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                    "
                  >
                    Save
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </container>
  </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import Container from "@/Layouts/Container";
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'

export default {
  components: {
    BreezeAuthenticatedLayout,
    Container,
  },

  setup () {
    const form = reactive({
      first_name: null,
      last_name: null,
      email_address: null,
    })

    function submit() {
      Inertia.post('/subscriptions/complete', form)
    }

    return { form, submit }
  },
};
</script>
