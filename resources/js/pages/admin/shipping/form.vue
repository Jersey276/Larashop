<script setup lang="ts">
import CardAction from '@/components/ui/card/CardAction.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

import Card from '@/components/ui/card/Card.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';

import { ref } from 'vue';

interface ShippingForm {
    id: number | null;
    name: string;
    cost: number;
    delivery_time: number;
    is_active: boolean;
}

const page = usePage();
const formErrors = ref(page.props.errors || {});

const formData = ref<ShippingForm>((page.props.shipping as ShippingForm) || {
    id: null,
    name: '',
    cost: 0.00,
    delivery_time: 0,
    is_active: false,
});


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('admin.dashboard'),
    },
    {
        title: 'Transporteur',
        href: route('admin.shipping.index'),
    },
    {
        title: formData.value.id ? 'Modifier ' + formData.value.name : 'Nouveau Transporteur',
        href: route('api.shipping.store'),
    },
];

const submit = async () => {
    if (formData.value.id) {
        // Update
        await fetch(`/api/shipping/${formData.value.id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData.value),
        });
    } else {
        // Create
        await fetch('/api/shipping', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData.value),
        });
    }
    // Redirige ensuite avec Inertia
    router.visit(route('admin.shipping.index'));
};

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Transporteur" />
        <div class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <Card>
                    <CardHeader>
                        <CardTitle>{{ formData.id ? 'Modifier ' + formData.name : 'Nouveau Transporteur' }}</CardTitle>
                    </CardHeader>
                    <form @submit.prevent="submit">
                        <input type="hidden" name="_token" :value="page.props.csrf" />
                        <input type="hidden" name="id" v-model="formData.id" />
                        <CardContent>
                            <div class="flex flex-row justify-between">
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                    <input v-model="formData.name" type="text" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required />
                                    <p v-if="formErrors.name" class="mt-2 text-sm text-red-600">{{ formErrors.name }}</p>
                                </div>
                                <div class="mb-4">
                                    <label for="cost" class="block text-sm font-medium text-gray-700">Cost</label>
                                    <input v-model="formData.cost" step="0.01" type="number" id="cost" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required />
                                    <p v-if="formErrors.cost" class="mt-2 text-sm text-red-600">{{ formErrors.cost }}</p>
                                </div>
                                <div class="mb-4">
                                    <label for="delivery_time" class="block text-sm font-medium text-gray-700">Delivery Time</label>
                                    <input v-model="formData.delivery_time" type="number" id="delivery_time" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required />
                                    <p v-if="formErrors.delivery_time" class="mt-2 text-sm text-red-600">{{ formErrors.delivery_time }}</p>
                                </div>
                                </div>
                                <div class="mb-4">
                                    <label for="is_active" class="block text-sm font-medium text-gray-700">Is Active</label>
                                    <input v-model="formData.is_active" type="checkbox" id="is_active" class="mt-1 block" />
                                    <p v-if="formErrors.is_active" class="mt-2 text-sm text-red-600">{{ formErrors.is_active }}</p>
                                </div>
                            
                        </CardContent>
                        <CardAction>
                            <div class="m-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Save
                            </button>
                            </div>
                        </CardAction>
                    </form>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>