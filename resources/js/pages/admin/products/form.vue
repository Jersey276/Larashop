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
import CategoryTree from '@/components/CategoryTree.vue';

const page = usePage();
const formErrors = ref(page.props.errors || {});
const categories = page.props.categories || [];
const formData = ref(page.props.product || {
    id: null,
    name: '',
    reference: '',
    description: '',
    sku: '',
    price: 0.00,
    stock: 0,
    categories: [],
    category_id: null,
});

const treeCategories = categories;

const submit = async () => {
    if (formData.value.id) {
        // Update
        await fetch(`/api/products/${formData.value.id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData.value),
        });
    } else {
        // Create
        await fetch('/api/products', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData.value),
        });
    }
    // Redirige ensuite avec Inertia
    router.visit(route('admin.products.index'));
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('admin.dashboard'),
    },
    {
        title: 'products',
        href: route('admin.products.index'),
    },
    {
        title: formData.id ? 'Modifier ' + formData.name : 'Nouveau Produit',
        href: formData.id ? route('admin.products.edit', formData.id) : route('admin.products.add'),
    },
];

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="produits" />
        <div class="p-4">
            <form @submit.prevent="submit">
            <input type="hidden" name="_token" :value="page.props.csrf" />
            <input type="hidden" name="id" v-model="formData.id" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <Card>
                    <CardHeader>
                        <CardTitle>{{ formData.id ? 'Modifier ' + formData.name : 'Nouveau produit' }}</CardTitle>
                    </CardHeader>

                        <CardContent>
                            <div class="flex flex-row justify-between">
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                    <input v-model="formData.name" type="text" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required />
                                    <p v-if="formErrors.name" class="mt-2 text-sm text-red-600">{{ formErrors.name }}</p>
                                </div>
                                <div class="mb-4">
                                    <label for="reference" class="block text-sm font-medium text-gray-700">Référence</label>
                                    <input v-model="formData.reference" type="text" id="reference" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required />
                                    <p v-if="formErrors.reference" class="mt-2 text-sm text-red-600">{{ formErrors.reference }}</p>
                                </div>
                                <div class="mb-4">
                                    <label for="sku" class="block text-sm font-medium text-gray-700">EAN</label>
                                    <input v-model="formData.sku" type="text" id="sku" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required />
                                    <p v-if="formErrors.sku" class="mt-2 text-sm text-red-600">{{ formErrors.sku }}</p>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea v-model="formData.description" id="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                <p v-if="formErrors.description" class="mt-2 text-sm text-red-600">{{ formErrors.description }}</p>
                            </div>
                            <div>
                                <div class="mb-4">
                                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                                    <input v-model="formData.price" step="0.01" type="number" id="price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required />
                                    <p v-if="formErrors.price" class="mt-2 text-sm text-red-600">{{ formErrors.price }}</p>
                                </div>
                                <div class="mb-4">
                                    <label for="stock" class="block text-sm font-medium text-gray-700">stock</label>
                                    <input v-model="formData.stock" type="number" id="stock" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required />
                                    <p v-if="formErrors.stock" class="mt-2 text-sm text-red-600">{{ formErrors.stock }}</p>
                                </div>
                            </div>
                            
                        </CardContent>
                        <CardAction>
                            <div class="m-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Save
                            </button>
                            </div>
                        </CardAction>
                </Card>
                <Card>
                    <CardHeader>
                        <CardTitle>Catégories</CardTitle>
                    </CardHeader>
                    <CardContent>
                    <CategoryTree
                        :categories="treeCategories"
                        :selectedCategories="formData.categories"
                        :defaultCategory="formData.category_id"
                        @update:selectedCategories="formData.categories = $event"
                        @update:defaultCategory="formData.category_id = $event"
                    />
                        <p v-if="formErrors.categories" class="mt-2 text-sm text-red-600">{{ formErrors.categories }}</p>
                        <p v-if="formErrors.category_id" class="mt-2 text-sm text-red-600">{{ formErrors.category_id }}</p>
                    </CardContent>
                </Card>
                </div>
            </form>
        </div>
    </AppLayout>
</template>