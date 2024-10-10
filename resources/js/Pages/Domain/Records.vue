<script setup>
import {Head, usePage} from '@inertiajs/vue3'
import {computed} from 'vue'

import Layout from '../../Layouts/Portal.vue'

const page = usePage()
const auth = computed(() => page.props.auth)
const status = computed(() => page.props.status)
const records = computed(() => page.props.records)
const statuses = computed(() => page.props.status_counts)

</script>

<template>
    <Head title="Records" />
    <Layout>
        <template #nav-bar>
            <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                <a href="/records"
                   :class="status === null ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                   class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium">
                    All
                </a>
                <a :href="`/records?status=${state}`"
                   :class="status === state ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                   class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium" v-for="{ state, count } in statuses">
                    {{ state }}
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
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6"></th>
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
                        {{ record.state }}
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-right text-sm text-gray-500" v-if="record.state === 'Completed'">
                        <a :href="`/records/${record.id}/export`" class="mr-2 inline-flex items-center rounded-md bg-white px-2.5 py-1.5 font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-30 disabled:hover:bg-white">
                            Download
                        </a>
                        <a :href="`/records/${record.id}`" class="inline-flex items-center rounded-md bg-white px-2.5 py-1.5 font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-30 disabled:hover:bg-white">
                            View
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </template>
    </Layout>
</template>
