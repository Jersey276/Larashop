<script lang="js" setup>
import UserLayout from '@/layouts/UserLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';

const page = usePage();
const category = page.props.category;
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
            <ul>
                <li v-for="subCategory in children" :key="subCategory.id">
                    <a :href="route('products.index', { name: subCategory.name })" class="text-blue-600 hover:underline">
                        {{ subCategory.name }}
                    </a>
                    <span v-if="subCategory.description" class="text-gray-500 ml-2">{{ subCategory.description }}</span>
                </li>
            </ul>
        </template>
        <template v-if="products && products.data && products.data.length">
            <h2>Produits</h2>
            <ul>
                <li v-for="product in products.data" :key="product.id">
                    {{ product.name }}
                </li>
            </ul>
        </template>
    </UserLayout>
</template>