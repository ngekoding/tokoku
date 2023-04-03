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
    },
    {
        to: 'customers',
        label: 'Customer',
        icon: mdiAccountOutline
    },
    {
        to: 'items',
        label: 'Item',
        icon: mdiPackageVariantClosed
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
