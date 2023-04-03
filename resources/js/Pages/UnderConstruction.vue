<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Head } from '@inertiajs/vue3';

defineOptions({ layout: DefaultLayout });
</script>

<template>
    <Head title="Under Construction" />

    <div class="py-12">
        <div class="p-6 bg-white rounded-md shadow-sm">
            <h3 class="text-xl font-bold text-gray-700">Under Construction</h3>
            <p class="text-gray-500">We are sorry! This feature is not completed yet, you can back soon.</p>
        </div>
    </div>
</template>
