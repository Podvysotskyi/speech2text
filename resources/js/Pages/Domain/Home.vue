<script setup>
import {Head, useForm} from '@inertiajs/vue3'
import {useTemplateRef} from 'vue'

import Layout from '../../Layouts/Portal.vue'

const form = useForm({
    record: null,
})

const fileInput = useTemplateRef('fileInput')

function uploadRecord(files) {
    form.record = files[0]
    form.post('/records')
}
</script>

<template>
    <Head title="Home"/>
    <Layout>
        <template #nav-bar>
            <form @submit.prevent="uploadRecord">
                <input class="hidden" type="file" ref="fileInput" @change="uploadRecord($event.target.files)">
                <button @click.prevent="fileInput.click()"
                        class="my-3 inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Upload New Record
                </button>
            </form>
        </template>

        <template #default>
            <h1>HOME</h1>
        </template>
    </Layout>
</template>
