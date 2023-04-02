<script setup>
import { computed } from 'vue';

const emit = defineEmits(['update:modelValue', 'change']);

const props = defineProps({
    modelValue: {
        default: null
    },
    value: {
        default: null,
    },
    label: {
        type: String
    }
});

const modelValueLocal = computed({
    get: () => props.modelValue,
    set: (val) => {
        emit('update:modelValue', val)
    }
})

const isChecked = computed(() => props.modelValue === props.value)
</script>

<template>
    <label class="flex items-center py-1">
        <input
            type="radio"
            v-model="modelValueLocal"
            :value="value"
            :checked="isChecked"
            class="rounded-full border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
            @change="emit('change', $event.target.value)"
        />
        <div class="ml-2 text-sm text-gray-700">{{ label }}</div>
    </label>
</template>
