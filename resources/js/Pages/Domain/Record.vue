<script setup>
import {Head, usePage} from '@inertiajs/vue3'
import {computed} from 'vue'

import Layout from '../../Layouts/Portal.vue'

const page = usePage()
const auth = computed(() => page.props.auth)
const record = computed(() => page.props.record)

</script>

<template>
    <Head :title="record.name" />
    <Layout>
        <template #nav-bar>
            <div class="ml-3 mt-5 text-sm font-semibold leading-6 text-gray-900">
                {{ record.name }}
            </div>
        </template>

        <template #default>
            <div class="flex mb-3" v-for="transcription in record.transcriptions">
                <div class="divide-y divide-gray-200 overflow-hidden rounded-lg bg-white shadow">
                    <div class="px-4 py-2 text-lg font-bold">
                        {{ transcription.speaker.name }}
                    </div>
                    <div class="px-4 py-2 text-sm leading-6 text-gray-500 text-justify">
                        {{ transcription.text }}
                    </div>
                </div>
            </div>
        </template>
    </Layout>
</template>
