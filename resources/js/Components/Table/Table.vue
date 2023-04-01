<script setup>
import { computed } from 'vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    data: {
        type: Object,
        required: true,
        default: () => ({})
    },
    search: {
        type: String
    }
})

const emit = defineEmits(['update:search']);

const searchLocal = computed({
  get: () => props.search,
  set: (val) => emit('update:search', val)
})
</script>

<template>
    <div class="p-4">
        <label for="table-search" class="sr-only">Search</label>
        <div class="relative mt-1">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
            </div>
            <input
                v-model="searchLocal"
                type="text"
                id="table-search"
                class="block w-full md:w-80 p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search for items"
            >
        </div>
    </div>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <slot name="header" />
                </tr>
            </thead>
            <tbody>
                <slot name="default" />
            </tbody>
        </table>
    </div>
    <div class="p-4 flex justify-between items-center">
        <div class="text-sm text-gray-500">
            Page {{  props.data.current_page }} of {{ props.data.last_page }}
        </div>
        <Pagination :links="props.data.links" />
    </div>
</template>
