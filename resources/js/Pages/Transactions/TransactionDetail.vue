<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Link, Head, router } from '@inertiajs/vue3';
import { mdiArrowLeft } from '@mdi/js';
import { formatCurrency } from '@/utils';
import dayjs from '@/dayjs';

defineOptions({ layout: DefaultLayout });

defineProps({
    order: {
        type: Object,
        default: () => ({})
    }
})
</script>

<template>
    <Head title="Detail Transaction" />

    <BaseButton
        with-icon
        @click="router.get(route('transactions'))"
        class="mx-4 sm:mx-0"
    >
        <BaseIcon :path="mdiArrowLeft" class="mr-1" /> Back
    </BaseButton>

    <div class="mt-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-4 flex items-center justify-between border-b border-gray-100">
            <div>{{ order.code }}</div>
            <div>{{ dayjs(order.date).format('LL') }}</div>
        </div>
        <div class="p-4 border-b-2 border-gray-100 space-y-3">
            <div>
                <div class="text-sm text-gray-500">Name</div>
                <div class="text-gray-800 font-medium">{{ order.customer.name }}</div>
            </div>
            <div>
                <div class="text-sm text-gray-500">Phone</div>
                <div class="text-gray-800 font-medium">{{ order.customer.phone }}</div>
            </div>
            <div>
                <div class="text-sm text-gray-500">Address</div>
                <div class="text-gray-800 font-medium">{{ order.address }}</div>
            </div>
        </div>
        <div class="p-4 bg-gray-50 border-b border-gray-200 space-y-4 divide-y divide-gray-200 divide-dashed">
            <div
                v-for="(orderItem, i) in order.order_items"
                :key="'item-' + i"
                class="flex items-center space-x-2 pt-4 first:pt-0"
            >
                <div class="flex-grow">
                    <div class="text-gray-800 font-medium text-lg leading-tight">{{ orderItem.item.name }}</div>
                    <div class="flex flex-wrap gap-x-4 gap-y-1">
                        <div class="text-gray-500 text-sm">x{{ orderItem.qty }}</div>
                        <div class="text-gray-500 text-sm">Discount: {{ formatCurrency(orderItem.discount) }}</div>
                        <div v-if="orderItem.note" class="text-gray-500 text-sm pl-2">Note: {{ orderItem.note }}</div>
                    </div>
                </div>
                <div class="text-gray-700">{{ formatCurrency(orderItem.price) }}</div>
            </div>
        </div>
        <table class="w-full bg-gray-50 text-gray-700">
            <tr class="border-b border-gray-200">
                <td class="px-4 py-2.5 border-r border-gray-200 text-right font-medium">Sub-total</td>
                <td class="px-4 py-2.5 text-right sm:w-[250px]">{{ formatCurrency(order.subtotal)  }}</td>
            </tr>
            <tr class="border-b border-gray-200">
                <td class="px-4 py-2.5 border-r border-gray-200 text-right font-medium">Discount</td>
                <td class="px-4 py-2.5 text-right">-{{ formatCurrency(order.discount)  }}</td>
            </tr>
            <tr>
                <td class="px-4 py-2.5 border-r border-gray-200 text-right font-medium">Total</td>
                <td class="px-4 py-2.5 text-right text-xl text-blue-500 font-medium">{{ formatCurrency(order.total)  }}</td>
            </tr>
        </table>
    </div>
</template>
