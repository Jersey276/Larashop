<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router as $inertia } from '@inertiajs/vue3';
import DataTable from '@/components/DataTable.vue';
import Card from '@/components/ui/card/Card.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardContent from '@/components/ui/card/CardContent.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('admin.dashboard'),
    },
    {
        title: 'Categories',
        href: route('admin.categories.index'),
    },
];

</script>
<template>
    <Head title="Categories" />
    <AppLayout :breadcrumbs="breadcrumbs">

        <Card>
            <CardHeader>
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold">Categories List</h2>
                    <a :href="route('admin.categories.add')" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Nouvelle catégorie
                    </a>
                </div>
            </CardHeader>
            <CardContent>
                <DataTable :columns="columns" :api-url="route('api.categories.index')" :action-buttons="actionButtons" />
            </CardContent>
        </Card>
    </AppLayout>
</template>
<script lang="ts">

    export default {
    components: {
        DataTable
    },
    data() {
        return {
            columns: [
                { label: 'ID', field: 'id' },
                { label: 'Nom', field: 'name' },
                { label: 'Description', field: 'description' },
                { label: 'parent', field: 'parent_name' },
            ],
            actionButtons: [
                {
                    label: 'Modifier',
                    action: (item: any) => {
                        $inertia.visit(route('admin.categories.edit', { category: item.id }));
                    }
                },
            ],
        };
    },
    };
</script>