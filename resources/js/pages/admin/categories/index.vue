<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage, router as $inertia } from '@inertiajs/vue3';
import DataTable from '@/components/DataTable.vue';
import Sidebar from '@/components/ui/sidebar/Sidebar.vue';
import SidebarHeader from '@/components/ui/sidebar/SidebarHeader.vue';
import SidebarContent from '@/components/ui/sidebar/SidebarContent.vue';
import SidebarFooter from '@/components/ui/sidebar/SidebarFooter.vue';
import Card from '@/components/ui/card/Card.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import { ref } from 'vue';
import { Link } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Categories',
        href: '/categories',
    },
];

const page = usePage();

const categories = page.props.categories || [];

</script>
<template>
    <Head title="Categories" />
    <AppLayout :breadcrumbs="breadcrumbs">

        <Card>
            <CardHeader>
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold">Categories List</h2>
                    <a :href="route('admin.categories.add')" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Add Category
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