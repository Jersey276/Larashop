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
        title: 'Commande',
        href: route('admin.orders.index'),
    },
];

</script>
<template>
    <Head title="Categories" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <DataTable :api-url="route('api.orders.index')" :columns="[
                { label: 'ID', field: 'id' },
                { label: 'Date', field: 'created_at' },
                { label: 'Total', field: 'total' },
                { label: 'Statut', field: 'status' },
                { label: 'Client', field: 'client.name'}
            ]" :actionButtons="[
                {
                    label: 'Voir',
                    action: (item: any) => {
                        console.log('Voir commande', item);
                    }
                }
            ]" />
    </AppLayout>
</template>