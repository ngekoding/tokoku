import {
    mdiAccountOutline,
    mdiShieldAccountOutline,
    mdiViewDashboardOutline,
    mdiCartOutline,
    mdiPackageVariantClosed,
 } from '@mdi/js';

export default [
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
        icon: mdiShieldAccountOutline
    },
]
