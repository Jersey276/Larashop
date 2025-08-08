<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type User, type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import DataTable from '@/components/DataTable.vue';
import Card from '@/components/ui/card/Card.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import CardContent from '@/components/ui/card/CardContent.vue';

const page = usePage();
const user = page.props.user as User;
const orders = page.props.orders || [];

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('admin.dashboard'),
    },
    {
        title: 'Clients',
        href: route('admin.customers.index'),
    },
    {
        title: user.name,
        href: route('admin.customers.view', { id: user.id }),
    }
];
</script>
<template>
    <Head title="Clients" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <Card>
            <CardHeader>
                <CardTitle>Informations du client</CardTitle>
            </CardHeader>
            <CardContent>
                <div class="mb-4">
                    <strong>Nom:</strong> {{ user.name }}
                </div>
                <div class="mb-4">
                    <strong>Email:</strong> {{ user.email }}
                </div>
                <div class="mb-4">
                </div>
            </CardContent>
        </Card>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <Card>
                <CardHeader>
                    <CardTitle>Commandes du client</CardTitle>
                </CardHeader>
                <CardContent>
                    <DataTable :data="orders" :columns="[
                        { label: 'ID', field: 'id' },
                        { label: 'Date', field: 'created_at' },
                        { label: 'Total', field: 'total' },
                        { label: 'Statut', field: 'status' }
                    ]" :actionButtons="[
                        {
                            label: 'Voir',
                            action: (item: any) => {
                                console.log('Voir commande', item);
                            }
                        }
                    ]" />
                </CardContent>
            </Card>
        <Card>
            <CardHeader>
                <CardTitle>Adresses du client</CardTitle>
            </CardHeader>
            <CardContent>
                <DataTable :data="addresses" :columns="[
                    { label: 'ID', field: 'id' },
                    { label: 'Adresse', field: 'address' },
                    { label: 'Ville', field: 'city' },
                    { label: 'Code Postal', field: 'postal_code' }
                ]" />
            </CardContent>
            
        </Card>
        </div>

    </AppLayout>
</template>
<script lang="ts">


    export default {
    components: {
        DataTable,
    },
    };
</script>