<script lang="ts" setup>
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import UserLayout from '@/layouts/UserLayout.vue';
import { Product } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const page = usePage();

const user = page.props.auth.user;

const product = page.props.product as Product;

const addToCartForm = ref({
    _token: page.props.csrf,
    product_id: product.id,
    quantity: 1
})

const addToCart = async () => {
    await fetch('/api/cart/add', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'same-origin',
        body: JSON.stringify(addToCartForm.value),
    }).then(response => {
        if (response.ok) {
            // Optionally show a success message or update the cart state
            console.log('Product added to cart successfully');
        } else {
            console.error('Failed to add product to cart');
        }
    }).catch(error => {
        console.error('Error adding product to cart:', error);
    });
    // Optionally redirect or show a success message
};

</script>
<template>
    <Head :title="product.name" />
    <UserLayout>
        <article class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <PlaceholderPattern />
            </div>
            <div class="flex flex-col justify-between" schema="https://schema.org/Product">
                <div class="flex flex-row justify-between items-center mb-4">
                    <h1 itemprop="name">{{ product.name }}</h1>
                    <p itemprop="price">{{ product.price }}</p>
                </div>
                <div class="flex flex-col">
                    <p class="text-gray-500">Référence: {{ product.reference }}</p>
                    <p class="text-gray-500">EAN: {{ product.sku }}</p>
                    <p class="text-gray-500">Stock: {{ product.stock }}</p>
                </div>
                <form v-if="user" @submit.prevent="addToCart">
                    <input type="hidden" name="_token" :value="page.props.csrf" />
                    <input type="hidden" name="product_id" v-model="addToCartForm.product_id" />
                    <div class="flex items-center">
                        <input type="number" class="border border-gray-300 rounded p-2" name="quantity" v-model="addToCartForm.quantity" min="1" max="product.stock" />
                        <button type="submit" v-bind:disabled="addToCartForm.quantity < 1 || addToCartForm.quantity > product.stock" class="bg-blue-500 text-white px-4 py-2 rounded">Ajouter au panier</button>
                    </div>
                </form>
                <a v-else :href="route('login')" class="bg-blue-500 text-white px-4 py-2 rounded"> Se connecter pour acheter</a>
            </div>
        </article>
        <p>{{ product.description }}</p>
    </UserLayout>
</template>
<script lang="ts">
</script>