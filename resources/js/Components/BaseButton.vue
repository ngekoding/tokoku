<script setup>
import { computed } from 'vue';

const props = defineProps({
    type: {
        type: String,
        default: 'default',
        validator: (val) => {
            return ['default', 'primary', 'secondary', 'success', 'warning', 'danger'].includes(val)
        }
    },
    iconOnly: {
        type: Boolean,
        default: false,
    },
    withIcon: {
        type: Boolean,
        default: false,
    }
})

const typeClasses = {
    'default': 'border-transparent  bg-transparent hover:bg-gray-100 text-gray-500 hover:text-gray-700',
    'primary': 'border-transparent bg-blue-500 hover:bg-blue-400 text-white',
    'secondary': 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50',
    'success': 'border-transparent bg-green-500 hover:bg-green-400 text-white',
    'danger': 'border-transparent bg-red-500 hover:bg-red-400 text-white',
    'warning': 'border-transparent bg-orange-500 hover:bg-orange-400 text-white',
}

const typeClass = computed(() => typeClasses[props.type]);
const extraClass = computed(() => {
    if (props.iconOnly) return 'p-1';
    if (props.withIcon) return 'pl-2 pr-3 py-1';
    return 'px-4 py-2';
});
</script>

<template>
    <button
        class="inline-flex items-center justify-center border rounded-md font-semibold text-xs  uppercase tracking-widest transition ease-in-out duration-150"
        :class="[typeClass, extraClass]"
    >
        <slot />
    </button>
</template>
