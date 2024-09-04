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
        <h1>Records</h1>
    </Layout>
</template>
