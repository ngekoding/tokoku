<script setup>
import { ref, onMounted } from 'vue';

const props = defineProps({
    type: {
        type: String,
        default: 'success',
        validator: (val) => {
            return ['success', 'error'].includes(val)
        }
    },
    flash: {
        type: Boolean,
    }
})

const show = ref(true);

onMounted(() => {
    if (props.flash) {
        setTimeout(() => show.value = false, 3000);
    }
})
</script>

<template>
    <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
        <div
            v-if="show"
            class="p-4 text-sm rounded-lg"
            :class="{
                'text-green-800 bg-green-50': type === 'success',
                'text-red-800 bg-red-50': type === 'danger',
            }"
            role="alert"
        >
            <slot />
        </div>
    </Transition>
</template>
