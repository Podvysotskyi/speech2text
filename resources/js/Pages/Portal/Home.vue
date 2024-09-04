<script setup>
import {Head, usePage} from '@inertiajs/vue3'
import {computed} from 'vue'

import Layout from '../../Layouts/Portal.vue'

const page = usePage()
const auth = computed(() => page.props.auth)
</script>

<template>
    <Head title="Home" />
    <Layout>
        <template #nav-bar>
            <a href="#" class="my-3 inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Upload New Record
            </a>
        </template>

        <template #default>
            <h1>HOME</h1>
        </template>
    </Layout>
</template>
