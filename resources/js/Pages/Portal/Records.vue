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
            <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                <a href="/records" class="inline-flex items-center border-b-2 border-indigo-500 px-1 pt-1 text-sm font-medium text-gray-900">
                    All
                </a>
                <a href="/records/ready" class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                    Ready
                </a>
                <a href="/records/processing" class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                    Processing
                </a>
                <a href="/records/failed" class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                    Failed
                </a>
            </div>
        </template>

        <template #default>
            <h1>RECORDS</h1>
        </template>
    </Layout>
</template>
