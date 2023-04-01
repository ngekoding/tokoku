<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import BaseIcon from './BaseIcon.vue';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
    icon: {
        type: String,
    }
});

const classes = computed(() =>
    props.active
        ? 'flex items-center w-full pl-3 pr-4 py-2 text-left text-base font-medium text-blue-700 bg-blue-50 focus:outline-none focus:text-blue-800 focus:bg-blue-100 focus:border-blue-700 transition duration-150 ease-in-out'
        : 'flex items-center w-full pl-3 pr-4 py-2 text-left text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <BaseIcon
            v-if="props.icon"
            :path="props.icon"
            class="mr-2" />
        <slot />
    </Link>
</template>
