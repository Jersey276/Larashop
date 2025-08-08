<script setup lang="ts">
import UserLayout from '@/layouts/UserLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';

const page = usePage();
const categories = page.props.categories;
const products = page.props.products;
</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <UserLayout>
        <div class="flex h-full flex-1 flex-col gap-8 rounded-xl p-4 overflow-x-auto">
            <div class="w-full">
                <h2 class="text-xl font-bold mb-2">Catégories</h2>
                <div class="flex flex-wrap gap-4">
                    <div v-for="category in categories" :key="category.id" class="w-32 border rounded p-4 text-center my-2">
                        <a :href="route('products.index', category.name)" class="block py-2">
                            {{ category.name }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="w-full">
                <h2 class="text-xl font-bold mb-2">Derniers produits</h2>
            </div>
        </div>
    </UserLayout>
</template>