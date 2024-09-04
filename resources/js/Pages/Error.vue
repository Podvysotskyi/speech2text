<script setup>
import {Head, Link} from '@inertiajs/vue3'
import {computed} from 'vue'

const props = defineProps({
    auth: Boolean,
    status: Number,
    request_method: String,
    debug_message: String,
})

const title = computed(() => {
    return {
        503: 'Service Unavailable',
        500: 'Server Error',
        404: 'Page Not Found',
        403: 'Forbidden',
        405: 'Forbidden',
    }[props.status]
})

const description = computed(() => {
    return {
        503: 'Sorry, we are doing some maintenance. Please check back soon.',
        500: 'Whoops, something went wrong on our servers.',
        404: 'Sorry, the page you are looking for could not be found.',
        403: 'Sorry, you are forbidden from accessing this page.',
        405: `The <b>${props.request_method}</b> Method is not supported for route`
    }[props.status]
})
</script>

<template>
    <Head :title="title" />
    <main class="grid min-h-full place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8">
        <div class="text-center">
            <p class="text-3xl font-semibold text-indigo-600">
                {{ props.status }}
            </p>
            <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl">
                {{ title }}
            </h1>
            <p class="mt-6 text-base leading-7 text-gray-600" v-html="description" />
            <div class="border-yellow-400 bg-yellow-50 p-4 mt-3" v-if="debug_message">
                <div class="flex">
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            {{ debug_message }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-10 flex items-center justify-center gap-x-6">
                <Link :href="props.auth ? '/home' : '/'" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Go back home
                </Link>
            </div>
        </div>
    </main>
</template>
