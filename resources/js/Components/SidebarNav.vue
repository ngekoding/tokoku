<script setup>
import navLinks from '@/nav';
import NavLink from '@/Components/NavLink.vue';
import NavHeader from '@/Components/NavHeader.vue';
</script>

<template>
    <template v-for="nav in navLinks">
        <NavHeader v-if="nav.header" :text="nav.label" />
        <NavLink
            v-else
            :href="route(nav.to)"
            :active="$page.url.startsWith(`/${nav.to}`)"
            :icon="nav.icon"
        >
            {{ nav.label }}
        </NavLink>
    </template>
</template>
