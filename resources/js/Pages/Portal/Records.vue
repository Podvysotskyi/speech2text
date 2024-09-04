<script setup>
import {Head, usePage} from '@inertiajs/vue3'
import {computed} from 'vue'

import Layout from '../../Layouts/Portal.vue'

const page = usePage()
const auth = computed(() => page.props.auth)
const status = computed(() => page.props.status)

</script>

<template>
    <Head title="Home" />
    <Layout>
        <template #nav-bar>
            <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                <a href="/records"
                   :class="status === null ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                   class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium">
                    All
                </a>
                <a href="/records?status=ready"
                   :class="status === 'ready' ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                   class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium">
                    Ready
                </a>
                <a href="/records?status=processing"
                   :class="status === 'processing' ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                   class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium">
                    Processing
                </a>
                <a href="/records?status=failed"
                   :class="status === 'failed' ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                   class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium">
                    Failed
                </a>
            </div>
        </template>

        <template #default>
            <h1>RECORDS</h1>
        </template>
    </Layout>
</template>
