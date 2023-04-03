import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import {
    mdiAccountOutline,
    mdiShieldAccountOutline,
    mdiViewDashboardOutline,
    mdiCartOutline,
    mdiPackageVariantClosed,
 } from '@mdi/js';

const navs = [
    {
        to: 'dashboard',
        label: 'Dashboard',
        icon: mdiViewDashboardOutline
    },
    {
        to: 'transactions',
        label: 'Transaction',
        icon: mdiCartOutline
    },
    {
        header: true,
        label: 'Settings',
        allowedRoles: ['super admin']
    },
    {
        to: 'customers',
        label: 'Customer',
        icon: mdiAccountOutline,
        allowedRoles: ['super admin']
    },
    {
        to: 'items',
        label: 'Item',
        icon: mdiPackageVariantClosed,
        allowedRoles: ['super admin']
    },
    {
        to: 'users',
        label: 'User',
        icon: mdiShieldAccountOutline,
        allowedRoles: ['super admin']
    },
];

export const visibleLinks = computed(() => {
    return navs.filter(nav => {
        return !nav.allowedRoles || (nav.allowedRoles && nav.allowedRoles.includes(usePage().props.auth.user.role));
    });
});

export default navs;
