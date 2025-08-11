<script lang="ts" setup>

import { useCart } from '@/composables/useCart';

const page = usePage();

const product = page.props.product as Product;

const addToCartForm = ref({
    _token: page.props.csrf,
    id: product.id,
    quantity: 1
})

const { addToCart: addToCartSidebar } = useCart();
const addToCart = async () => {
    // Optionally send to backend as before
    await fetch('/api/cart', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(addToCartForm.value),
    });
    // Add to sidebar cart
    addToCartSidebar({
        id: product.id,
        name: product.name,
        price: product.price,
        quantity: addToCartForm.value.quantity
    });
};

</script>
<template>
    <Head :title="product.name" />
    <UserLayout>
        <article class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <PlaceholderPattern />
            </div>
            <div class="flex flex-col justify-between">
                <div class="flex flex-row justify-between items-center mb-4">
                    <h1>{{ product.name }}</h1>
                    <p>{{ product.price }}</p>
                </div>
                <div class="flex flex-col">
                    <p class="text-gray-500">Référence: {{ product.reference }}</p>
                    <p class="text-gray-500">EAN: {{ product.sku }}</p>
                    <p class="text-gray-500">Stock: {{ product.stock }}</p>
                </div>
                <form @submit.prevent="addToCart">
                    <input type="hidden" name="_token" :value="page.props.csrf" />
                    <input type="hidden" name="id" v-model="addToCartForm.id" />
                    <div class="flex items-center">
                        <input type="number" class="border border-gray-300 rounded p-2" name="quantity" v-model="addToCartForm.quantity" min="1" max="product.stock" />
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Ajouter au panier</button>
                    </div>
                </form>
            </div>
        </article>
        <p>{{ product.description }}</p>
    </UserLayout>
</template>
<script lang="ts">
</script>