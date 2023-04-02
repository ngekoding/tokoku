<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import BaseButton from '@/Components/BaseButton.vue';
import { mdiArrowLeft } from '@mdi/js';
import BaseIcon from '@/Components/BaseIcon.vue';
import Alert from '@/Components/Alert.vue';
import Radio from '@/Components/Radio.vue';

defineOptions({ layout: DefaultLayout });

const form = useForm({
    name: '',
    email: '',
    password: '',
    role: 'staff',
});

const submit = () => {
    form.post(route('users.create'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Add User" />

    <div class="max-w-xl mx-auto">

        <BaseButton
            with-icon
            @click="router.get(route('users'))"
            class="mx-4 sm:mx-0"
        >
            <BaseIcon :path="mdiArrowLeft" class="mr-1" /> Back
        </BaseButton>

        <div class="mt-2 p-4 sm:p-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <Alert
                v-if="form.recentlySuccessful"
                type="success"
                class="mb-4"
                flash
            >
                <span class="font-medium">Success!</span> The new user successfully added.
            </Alert>

            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="name" value="Name" />

                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mt-4">
                    <InputLabel for="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autocomplete="username"
                    />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Password" />

                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                    />

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="mt-4">
                    <InputLabel for="role" value="Role" />

                    <Radio v-model="form.role" value="staff" label="Staff" />
                    <Radio v-model="form.role" value="super admin" label="Super Admin" />

                    <InputError class="mt-2" :message="form.errors.role" />
                </div>

                <BaseButton
                    type="success"
                    class="mt-4"
                    :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                >
                    Save
                </BaseButton>
            </form>
        </div>
    </div>
</template>
