<script lang="ts" setup>
import UserLayout from '@/layouts/UserLayout.vue';
import { Category } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';

const page = usePage();
const category = page.props.category as Category;
const children = page.props.children || [];
const products = page.props.products;
</script>
<template>
   <Head :title="category.name" />
    <UserLayout>
        <h1>{{ category.name }}</h1>
        <p>{{ category.description }}</p>
        <template v-if="children.length">
            <h2>Sous-catégories</h2>
            <ul class="grid grid-cols-1 md:grid-cols-6 gap-4">
                <li class="border p-4 rounded" v-for="subCategory in children" :key="subCategory.id">
                    <a :href="route('products.index', { category: subCategory.uri })" class="text-blue-600 hover:underline">
                        {{ subCategory.name }}
                    </a>
                    <span v-if="subCategory.description" class="text-gray-500 ml-2">{{ subCategory.description }}</span>
                </li>
            </ul>
        </template>
        <template v-if="products && products.data && products.data.length">
            <h2>Produits</h2>
            <ul class="grid grid-cols-1 md:grid-cols-6 gap-4">
                <li class="border p-4 rounded" v-for="product in products.data" :key="product.id">
                    <a :href="route('products.view', { category: category.uri, product: product.uri })">{{ product.name }}</a>
                </li>
            </ul>
        </template>
    </UserLayout>
</template>