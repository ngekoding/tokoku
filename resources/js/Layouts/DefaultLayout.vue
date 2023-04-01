<script setup>
import { ref } from 'vue'
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import SidebarNav from '@/Components/SidebarNav.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import {
    mdiAccountOutline,
    mdiChevronDown,
    mdiExitToApp,
} from '@mdi/js';
import ResponsiveNav from '@/Components/ResponsiveNav.vue';
import BaseButton from '@/Components/BaseButton.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    pageTitle: {
        type: String,
        default: 'Dashboard'
    }
})

const showingNavigationDropdown = ref(false)
</script>

<template>
    <div class="min-h-screen bg-gray-100 md:flex">
        <!-- Sidebar Navigation Menu -->
        <div class="hidden md:block fixed w-[350px] h-screen bg-white border-r border-gray-200">
            <header class="flex items-center h-16 px-4 border-b border-gray-200">
                <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
                <h1 class="text-xl font-bold ml-2">{{ $page.props.appName }}</h1>
            </header>
            <div class="max-h-[calc(100vh-64px)] overflow-y-auto pt-4 space-y-2">
                <SidebarNav />
            </div>
        </div>

        <header class="fixed left-0 right-0 h-16 px-4 flex items-center justify-between bg-white border-b border-gray-200 md:left-[350px]">
            <div class="flex items-center">
                <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800 mr-2 md:hidden" />
                <h2 class="font-medium text-base text-gray-800 leading-none">
                    {{ pageTitle  }}
                </h2>
            </div>

            <div class="hidden md:flex sm:items-center sm:ml-6">
                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button
                                    type="button"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                >
                                    {{ $page.props.auth.user.name }}
                                    <BaseIcon :path="mdiChevronDown" class="ml-2" />
                                </button>
                            </span>
                        </template>

                        <template #content>
                            <DropdownLink
                                :href="route('profile.edit')"
                                :icon="mdiAccountOutline"
                            >
                                Profile
                            </DropdownLink>
                            <DropdownLink
                                :href="route('logout')"
                                :icon="mdiExitToApp"
                                method="post"
                                as="button"
                                class="text-red-600"
                            >
                                Log Out
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center md:hidden">
                <button
                    @click="showingNavigationDropdown = true"
                    class="inline-flex items-center justify-center p-2 -mr-2 text-gray-400"
                >
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                    </svg>
                </button>
            </div>
        </header>

        <!-- Responsive Navigation Menu -->
        <div class="md:hidden">
            <!-- Overlay -->
            <div
                v-if="showingNavigationDropdown"
                class="fixed h-screen w-screen bg-black/70 backdrop-blur-sm z-40"
                @click="showingNavigationDropdown = false"
            />
            <transition
                enter-active-class="transition duration-150 ease-out"
                enter-from-class="transform translate-x-full"
                enter-to-class="transform translate-x-0"
                leave-active-class="transition duration-150 ease-out"
                leave-from-class="transform translate-x-0"
                leave-to-class="transform translate-x-full"
            >
                <nav
                    v-if="showingNavigationDropdown"
                    class="fixed h-screen w-10/12 right-0 bg-white z-50"
                >
                    <div class="h-16 flex justify-end px-3">
                        <button
                            @click="showingNavigationDropdown = false"
                            class="inline-flex items-center justify-center p-2 text-gray-400"
                        >
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                    </button>
                    </div>
                    <div class="px-4 pb-4 flex items-center border-b border-gray-100">
                        <div class="flex-shrink-0 w-14 h-14 bg-gray-100 flex items-center justify-center rounded-full text-xl font-bold text-black/30">
                            {{ $page.props.auth.user.name.charAt(0) }}
                        </div>
                        <div class="px-2 flex-grow">
                            <div class="font-medium text-base text-gray-800 leading-none line-clamp-1">{{ $page.props.auth.user.name }}</div>
                            <div class="font-medium text-sm text-gray-500 line-clamp-1">{{ $page.props.auth.user.email }}</div>
                        </div>
                        <Link
                            :href="route('logout')"
                            method="post"
                            class="text-xs text-red-500 flex-shrink-0"
                        >
                            <BaseIcon :path="mdiExitToApp" class="-ml-1" />
                        </Link>
                    </div>
                    <div class="max-h-[calc(100vh-137px)] overflow-y-auto pt-4 space-y-1">
                        <ResponsiveNav />
                    </div>
                </nav>
            </transition>
        </div>

        <main class="pt-[85px] w-full md:pl-[350px]">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <slot></slot>
            </div>
        </main>
    </div>
</template>
