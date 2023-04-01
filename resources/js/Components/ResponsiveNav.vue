<script setup>
import navLinks from '@/nav';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import NavHeader from '@/Components/NavHeader.vue';
</script>

<template>
    <template v-for="nav in navLinks">
        <NavHeader v-if="nav.header" :text="nav.label" />
        <ResponsiveNavLink
            v-else
            :href="route(nav.to)"
            :active="$page.url.startsWith(`/${nav.to}`)"
            :icon="nav.icon"
        >
            {{ nav.label }}
        </ResponsiveNavLink>
    </template>
</template>
