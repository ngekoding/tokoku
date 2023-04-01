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

defineOptions({ layout: DefaultLayout });

const props = defineProps({
    user: {
        type: Object,
        default: () => ({}),
    }
})

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: '',
});

const submit = () => {
    form.patch(route('users.update', props.user.id), {
        onSuccess: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Edit User" />

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
                <span class="font-medium">Success!</span> The user successfully updated.
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
