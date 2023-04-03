<script setup>
import { ref, watch } from 'vue';
import { Link, Head, router } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import dayjs from '@/dayjs';
import { formatCurrency } from '@/utils';
import Table from '@/Components/Table/Table.vue';
import TableHeader from '@/Components/Table/TableHeader.vue';
import TableRow from '@/Components/Table/TableRow.vue';
import TableColumn from '@/Components/Table/TableColumn.vue';
import BaseButton from '@/Components/BaseButton.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import { mdiEyeOutline, mdiPencilOutline, mdiPlus, mdiTrashCanOutline } from '@mdi/js';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Alert from '@/Components/Alert.vue';

defineOptions({ layout: DefaultLayout })

const props = defineProps({
    transactions: {
        type: Object,
        default: () => ({})
    },
    filters: {
        type: Object,
        default: () => ({})
    },
    canUpdate: Boolean,
    canDestroy: Boolean,
})

const search = ref(props.filters.search)
watch(search, debounce((val) => {
    router.visit('/transactions', {
        data: { search: val },
        only: ['transactions'],
        preserveState: true
    })
}, 500))

const destroy = (id) => {
    if (confirm('Are you sure want to delete this transaction?')) {
        router.delete(`/transactions/${id}`)
    }
}
</script>

<template>
    <Head title="Transactions" />

    <BaseButton
        type="success"
        with-icon
        @click="router.get(route('transactions.create'))"
        class="mx-4 sm:mx-0"
    >
        <BaseIcon :path="mdiPlus" class="mr-1" /> Add Transaction
    </BaseButton>

    <div class="mt-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <Alert
            v-if="$page.props.flash.success"
            type="success"
            class="mx-4 mt-4"
            flash
        >
            <span class="font-medium">Success!</span> {{ $page.props.flash.success }}
        </Alert>

        <Table :data="transactions" v-model:search="search">
            <template #header>
                <TableHeader>Code</TableHeader>
                <TableHeader>Date</TableHeader>
                <TableHeader>Customer</TableHeader>
                <TableHeader>Total</TableHeader>
                <TableHeader>Actions</TableHeader>
            </template>
            <TableRow v-for="transaction in transactions.data" :key="transaction.id">
                <TableColumn>{{ transaction.code }}</TableColumn>
                <TableColumn>{{ dayjs(transaction.date).format('LL') }}</TableColumn>
                <TableColumn>{{ transaction.customer.name }}</TableColumn>
                <TableColumn>{{ formatCurrency(transaction.total) }}</TableColumn>
                <TableColumn class="flex gap-1">
                    <BaseButton
                        type="secondary"
                        @click="router.get(route('transactions.show', { id: transaction.id }))"
                        icon-only
                    >
                        <BaseIcon :path="mdiEyeOutline" />
                    </BaseButton>
                    <BaseButton
                        v-if="canUpdate"
                        type="success"
                        @click="router.get(route('transactions.edit', { id: transaction.id }))"
                        icon-only
                    >
                        <BaseIcon :path="mdiPencilOutline" />
                    </BaseButton>
                    <BaseButton
                        v-if="canDestroy"
                        type="danger"
                        @click="destroy(transaction.id)"
                        icon-only
                    >
                        <BaseIcon :path="mdiTrashCanOutline" />
                    </BaseButton>
                </TableColumn>
            </TableRow>
        </Table>
    </div>
</template>
