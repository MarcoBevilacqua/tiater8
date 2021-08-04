<template>
  <breeze-authenticated-layout>
    <template #header>
      <div class="mt-10 sm:mt-5">
        <div class="md:grid md:grid-cols-3 md:gap-6">
          <div class="mt-10 md:mt-5 md:col-span-3">
            <form @submit.prevent="update">
              <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                  <input type="hidden" v-model="form.id" name="id" id="id" />
                  <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                      <label
                        for="email"
                        class="block text-sm font-medium text-gray-700"
                        >Email</label
                      >
                      <input
                        v-model="form.subscription_email"
                        type="email"
                        name="subscription_email"
                        id="subscription_email"
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
                  </div>
                  <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                      <label
                        for="status"
                        class="block text-sm font-medium text-gray-700"
                        >Status</label
                      >
                      <select
                        v-model="form.status"
                        name="status"
                        id="status"
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
                      >
                        <option v-for="(key, value) in av_statuses"  :value="value" :key="value">{{key}}</option>
                      </select>
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
    </template>
  </breeze-authenticated-layout>
</template>

<script>
import Container from "@/Layouts/Container";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import { useForm } from "@inertiajs/inertia-vue3";

export default {
  components: {
    Container,
    BreezeAuthenticatedLayout,
  },

  props: {
    subscription: Array,
    _method: String,
    av_statuses: Array
  },

  data() {
    return { form:  this.$inertia.form({
      _method: this._method,
      id: this.subscription.id,
      subscription_email: this.subscription.subscription_email,
      status: this.subscription.status,
      av_statuses: this.av_statuses
    }),
    }
  },

  methods: {
    update() {
      this.form.post(this.route("subscriptions.update", this.subscription.id), {
        onSuccess: () => this.form.reset(),
      });
    },
  },
};
</script>
