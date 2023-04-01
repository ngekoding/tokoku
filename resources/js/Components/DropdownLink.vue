<script setup>
import { Link } from '@inertiajs/vue3';
import BaseIcon from './BaseIcon.vue';

defineProps({
    href: {
        type: String,
        required: true,
    },
    icon: {
        type: String,
    }
});
</script>

<template>
    <Link
        :href="href"
        class="flex items-center w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
    >
        <BaseIcon
            v-if="icon"
            :path="icon"
            class="mr-2" />
        <slot />
    </Link>
</template>
