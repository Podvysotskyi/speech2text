<script setup>
import {Head, usePage} from '@inertiajs/vue3'
import {computed} from 'vue'

import Layout from '../../Layouts/Portal.vue'

const page = usePage()
const auth = computed(() => page.props.auth)
const status = computed(() => page.props.status)
const records = computed(() => page.props.records)

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
            <table class="min-w-full divide-y divide-gray-300">
                <thead>
                <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Name</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>

                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                <tr v-for="record in records" :key="record.id">
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">
                        {{ record.name }}.{{ record.extension }}
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                        {{ record.created_at }}
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">

                    </td>
                </tr>
                </tbody>
            </table>
        </template>
    </Layout>
</template>
