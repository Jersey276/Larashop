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
        href: route('admin.dashboard'),
    },
    {
        title: 'Transporteurs',
        href: route('admin.shipping.index'),
    },
];

const page = usePage();

const shipping = page.props.shipping || [];

</script>
<template>
    <Head title="shipping" />
    <AppLayout :breadcrumbs="breadcrumbs">

        <Card>
            <CardHeader>
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold">shipping List</h2>
                    <a :href="route('admin.shipping.add')" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Nouveau Transporteurs
                    </a>
                </div>
            </CardHeader>
            <CardContent>
                <DataTable :columns="columns" :api-url="route('api.shipping.index')" :action-buttons="actionButtons" />
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
                { label: 'Cout', field: 'cost' },
                { label: 'Délai de livraison', field: 'delivery_time' },
                { label: 'Actif', field: 'is_active' }
            ],
            actionButtons: [
                {
                    label: 'Modifier',
                    action: (item: any) => {
                        $inertia.visit(route('admin.shipping.edit', { shipping: item.id }));
                    }
                },
            ],
        };
    },
    };
</script>