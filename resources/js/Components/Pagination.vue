<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: {
        type: Array,
        default: () => ([])
    }
})
</script>
<template>
    <nav class="inline-flex -space-x-px">
        <Link
            v-for="(link, i) in links" :key="i"
            :href="link.url"
            :disabled="!link.url"
            as="button"
            v-html="link.label"
            class="px-3 py-2 ml-0 leading-tight border first:rounded-l-lg last:rounded-r-lg"
            :class="{
                'text-blue-600 bg-blue-50 border-gray-300  hover:bg-blue-100 hover:text-blue-700': link.active,
                'text-gray-500 bg-white border-gray-300 hover:bg-gray-100 hover:text-gray-700': !link.active && link.url,
                'text-gray-500 bg-gray-100 border-gray-300 cursor-not-allowed': !link.url
            }"
            replace
            />
    </nav>
</template>
