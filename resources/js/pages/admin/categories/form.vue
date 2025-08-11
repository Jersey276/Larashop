<script setup lang="ts">
import CardAction from '@/components/ui/card/CardAction.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

import Card from '@/components/ui/card/Card.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import { ref } from 'vue';

const page = usePage();
const formErrors = ref(page.props.errors || {});
const categories = page.props.categories || [];
const formData = ref(page.props.category || {
    id: null,
    name: '',
    uri: '',
    description: '',
    parent_id: null,
});

const submit = async () => {
    if (formData.value.id) {
        // Update
        await fetch(`/api/categories/${formData.value.id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData.value),
        });
    } else {
        // Create
        await fetch('/api/categories', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData.value),
        });
    }
    // Redirige ensuite avec Inertia
    router.visit(route('admin.categories.index'));
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('admin.dashboard'),
    },
    {
        title: 'Categories',
        href: route('admin.categories.index'),
    },
    {
        title: formData.id ? 'Modifier ' + formData.name : 'Nouveau Categorie',
        href: route('admin.categories.add'),
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Categories" />
        <div class="p-4">
            <h1 class="text-2xl font-bold mb-4">Categories</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <Card>
                    <CardHeader>
                        <CardTitle>Add New Category</CardTitle>
                    </CardHeader>
                    <form @submit.prevent="submit">
                        <input type="hidden" name="_token" :value="page.props.csrf" />
                        <input type="hidden" name="id" v-model="formData.id" />
                        <CardContent>
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input v-model="formData.name" type="text" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required />
                                <p v-if="formErrors.name" class="mt-2 text-sm text-red-600">{{ formErrors.name }}</p>
                            </div>
                            <div class="mb-4">
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea v-model="formData.description" id="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                <p v-if="formErrors.description" class="mt-2 text-sm text-red-600">{{ formErrors.description }}</p>
                            </div>
                            <div class="mb-4">
                                <label for="uri" class="block text-sm font-medium text-gray-700">Slug</label>
                                <input v-model="formData.uri" type="text" id="uri" placeholder="slug" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required />
                                <p v-if="formErrors.uri" class="mt-2 text-sm text-red-600">{{ formErrors.uri }}</p>
                            </div>
                            <div class="mb-4">
                                <label for="parent_id" class="block text-sm font-medium text-gray-700">Parent Category</label>
                                <select v-model="formData.parent_id" id="parent_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">None</option>
                                    <option v-for="(name, id) in categories" :key="id" :value="id">{{ name }}</option>
                                </select>
                                <p v-if="formErrors.parent_id" class="mt-2 text-sm text-red-600">{{ formErrors.parent_id }}</p>
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