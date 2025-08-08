<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import DataTable from '@/components/DataTable.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('admin.dashboard'),
    },
    {
        title: 'Clients',
        href: route('admin.customers.index'),
    },
];
</script>
<template>
    <Head title="Clients" />
    <AppLayout :breadcrumbs="breadcrumbs">
        
        <DataTable :columns="columns" :api-url="route('api.users.index')" :actionButtons="actionButtons" />
    </AppLayout>
</template>
<script lang="ts">

    export default {
    components: {
        DataTable,
    },
    data() {
        return {
        columns: [
            { label: 'ID', field: 'id' },
            { label: 'Nom', field: 'name' },
            { label: 'Email', field: 'email'},
            { label: 'Commande passé', 'field': 'orders_count'}
        ],
        actionButtons: [
            {
            label: 'Éditer',
            action: (item: any) => {
                location.href = route('admin.users.view', { user: item.id })
            },
            },
            {
            label: 'Supprimer',
            action: (item: any) => {
                console.log('Supprimer', item);
                // Logique pour supprimer un élément
            },
            },
        ],
        };
    },
    };
</script>