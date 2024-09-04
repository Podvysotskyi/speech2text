<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3'

import Layout from '../../Layouts/Default.vue'
import {ExclamationCircleIcon} from "@heroicons/vue/20/solid/index.js";

const companyName = "My company"

const form = useForm({
    email: null,
    password: null,
});

function submit() {
    form.post('/login');
}

</script>

<template>
    <Head title="Login"/>
    <Layout>
        <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <Link href="/" class="">
                    <span class="sr-only">
                            {{ companyName }}
                        </span>
                    <img class="mx-auto h-10 w-auto"
                         src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company"/>
                </Link>
                <h2 class="mt-5 text-center text-2xl font-bold leading-9 tracking-tight text-white">
                    Sign in to your account
                </h2>
            </div>

            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                <form class="space-y-6" @submit.prevent="submit">
                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-white">
                            Email address
                        </label>
                        <div class="relative mt-2 rounded-md shadow-sm">
                            <input v-model="form.email" :disabled="form.processing" required
                                   @change="form.clearErrors('email')"
                                   id="email" name="email" type="email" autocomplete="email"
                                   :class="[form.errors.email ? 'ring-red-300 focus:ring-red-500' : 'ring-white/10 focus:ring-indigo-500']"
                                   class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6"/>
                            <div v-if="form.errors.email"
                                 class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <ExclamationCircleIcon class="h-5 w-5 text-red-500" aria-hidden="true"/>
                            </div>
                        </div>
                        <div v-if="form.errors.email" class="mt-2 text-sm text-red-600">
                            {{ form.errors.email }}
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm font-medium leading-6 text-white">
                                Password
                            </label>
                            <div class="text-sm">
                                <a href="#" class="font-semibold text-indigo-400 hover:text-indigo-300">
                                    Forgot password?
                                </a>
                            </div>
                        </div>
                        <div class="mt-2">
                            <input v-model="form.password" :disabled="form.processing" required
                                   id="password" name="password" type="password" autocomplete="current-password"
                                   class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6"/>
                        </div>
                    </div>

                    <div>
                        <button :disabled="form.processing" type="submit"
                                class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                            Sign in
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </Layout>
</template>
