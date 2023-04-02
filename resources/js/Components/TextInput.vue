<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: {
        type: String,
        required: true,
    },
    type: {
        type: String,
        default: 'text'
    }
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <textarea
        v-if="type === 'textarea'"
        class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="input">{{ modelValue }}</textarea>
    <input
        v-else
        :type="type"
        class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="input"
    />
</template>
