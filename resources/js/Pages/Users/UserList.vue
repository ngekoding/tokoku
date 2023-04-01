<script setup>
import { ref, watch } from 'vue';
import { Link, Head, router } from '@inertiajs/vue3';
import { debounce } from 'lodash'
import Table from '@/Components/Table/Table.vue';
import TableHeader from '@/Components/Table/TableHeader.vue';
import TableRow from '@/Components/Table/TableRow.vue';
import TableColumn from '@/Components/Table/TableColumn.vue';
import BaseButton from '@/Components/BaseButton.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import { mdiPencilOutline, mdiPlus, mdiTrashCanOutline } from '@mdi/js';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Alert from '@/Components/Alert.vue';

defineOptions({ layout: DefaultLayout })

const props = defineProps({
    users: {
        type: Object,
        default: () => ({})
    },
    filters: {
        type: Object,
        default: () => ({})
    }
})

const search = ref(props.filters.search)
watch(search, debounce((val) => {
    router.visit('/users', {
        data: { search: val },
        only: ['users'],
        preserveState: true
    })
}, 500))

const destroy = (id) => {
    if (confirm('Are you sure want to delete this user?')) {
        router.delete(`/users/${id}`)
    }
}
</script>

<template>
    <Head title="Users" />

    <BaseButton
        type="success"
        with-icon
        @click="router.get(route('users.create'))"
        class="mx-4 sm:mx-0"
    >
        <BaseIcon :path="mdiPlus" class="mr-1" /> Add User
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

        <Table :data="users" v-model:search="search">
            <template #header>
                <TableHeader>Name</TableHeader>
                <TableHeader>Email</TableHeader>
                <TableHeader>Role</TableHeader>
                <TableHeader>Actions</TableHeader>
            </template>
            <TableRow v-for="user in users.data" :key="user.id">
                <TableColumn>{{ user.name }}</TableColumn>
                <TableColumn>{{ user.email }}</TableColumn>
                <TableColumn>{{ user.role }}</TableColumn>
                <TableColumn class="flex gap-1">
                    <BaseButton
                        type="success"
                        @click="router.get(route('users.edit', { id: user.id }))"
                        icon-only
                    >
                        <BaseIcon :path="mdiPencilOutline" />
                    </BaseButton>
                    <BaseButton
                        type="danger"
                        @click="destroy(user.id)"
                        icon-only
                    >
                        <BaseIcon :path="mdiTrashCanOutline" />
                    </BaseButton>
                </TableColumn>
            </TableRow>
        </Table>
    </div>
</template>
