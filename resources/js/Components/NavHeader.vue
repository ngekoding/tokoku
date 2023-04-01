<script setup>
const props = defineProps({
    text: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <div class="font-medium text-sm text-gray-500 p-4 pb-2">
        {{ text }}
    </div>
</template>
