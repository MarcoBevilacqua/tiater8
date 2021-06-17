<template>
  <breeze-authenticated-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Users</h2>
    </template>
    <container>
      <div
        class="
          min-h-screen
          flex
          items-center
          justify-center
          bg-gray-50
          py-12
          px-4
          sm:px-6
          lg:px-8
        "
      >
        <div class="max-w-md w-full space-y-8">
          <div>
            <img
              class="mx-auto h-12 w-auto"
              src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg"
              alt="Workflow"
            />
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
              Sign in to your account
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
              <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">start your 14-day free trial</a>
            </p>
          </div>
          <form class="mt-8 space-y-6" action="/subscriptions/init" method="POST">
            <input type="hidden" name="remember" value="true" />
            <input type="hidden" name="_token" value="{{ token }}" />
            <div class="rounded-md shadow-sm -space-y-px">
              <div>
                <label for="customer_email" class="sr-only">Email address</label>
                <input
                  id="customer_email"
                  name="customer_email"
                  type="email"
                  autocomplete="email"
                  required=""
                  class="
                    appearance-none
                    rounded-none
                    relative
                    block
                    w-full
                    px-3
                    py-2
                    border border-gray-300
                    placeholder-gray-500
                    text-gray-900
                    rounded-t-md
                    focus:outline-none
                    focus:ring-indigo-500
                    focus:border-indigo-500
                    focus:z-10
                    sm:text-sm
                  "
                  placeholder="Email address"
                />
              </div>
            </div>

            <div>
              <button
                type="submit"
                class="
                  group
                  relative
                  w-full
                  flex
                  justify-center
                  py-2
                  px-4
                  border border-transparent
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
                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                  <button
                    class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400"
                    aria-hidden="true"
                    value="generate"
                  />
                </span>
                Generate Link
              </button>
            </div>
          </form>
        </div>
      </div>
    </container>
  </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import Container from "@/Layouts/Container";

export default {
  components: {
    BreezeAuthenticatedLayout,
    Container,
  },

  props: {
    token: String,
  },
};
</script>
