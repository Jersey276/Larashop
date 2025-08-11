<template>
  <transition name="slide">
    <div v-if="visible" class="cart-sidebar">
      <div class="cart-sidebar-header">
        <h3>Mon Panier</h3>
        <button class="close-btn" @click="$emit('close')">&times;</button>
      </div>
      <div class="cart-sidebar-content">
        <div v-if="cart.length === 0" class="empty-cart">Votre panier est vide.</div>
        <ul v-else>
          <li v-for="item in cart" :key="item.id" class="cart-item">
            <div class="item-info">
              <span class="item-name">{{ item.name }}</span>
              <span class="item-qty">x{{ item.quantity }}</span>
            </div>
            <span class="item-price">{{ item.price * item.quantity }} €</span>
          </li>
        </ul>
      </div>
      <div class="cart-sidebar-footer" v-if="cart.length">
        <div class="total">
          Total: <span>{{ total }} €</span>
        </div>
        <button class="checkout-btn" @click="$emit('checkout')">Passer la commande</button>
      </div>
    </div>
  </transition>
</template>

<script setup lang="ts">
import { computed, defineProps } from 'vue';

interface CartItem {
  id: number;
  name: string;
  price: number;
  quantity: number;
}

const props = defineProps<{ cart: CartItem[]; visible: boolean }>();
const total = computed(() => props.cart.reduce((sum, item) => sum + item.price * item.quantity, 0));
</script>

<style scoped>
.cart-sidebar {
  position: fixed;
  top: 0;
  right: 0;
  width: 350px;
  height: 100vh;
  background: #fff;
  box-shadow: -2px 0 8px rgba(0,0,0,0.1);
  z-index: 1000;
  display: flex;
  flex-direction: column;
  transition: transform 0.3s;
}
.slide-enter-active, .slide-leave-active {
  transition: transform 0.3s;
}
.slide-enter-from, .slide-leave-to {
  transform: translateX(100%);
}
.cart-sidebar-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  border-bottom: 1px solid #eee;
}
.close-btn {
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
}
.cart-sidebar-content {
  flex: 1;
  overflow-y: auto;
  padding: 1rem;
}
.cart-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}
.item-info {
  display: flex;
  flex-direction: column;
}
.item-name {
  font-weight: bold;
}
.item-qty {
  font-size: 0.9rem;
  color: #888;
}
.item-price {
  font-weight: bold;
}
.cart-sidebar-footer {
  padding: 1rem;
  border-top: 1px solid #eee;
  background: #fafafa;
}
.total {
  margin-bottom: 1rem;
  font-size: 1.1rem;
  font-weight: bold;
}
.checkout-btn {
  width: 100%;
  padding: 0.75rem;
  background: #1a73e8;
  color: #fff;
  border: none;
  border-radius: 4px;
  font-size: 1rem;
  cursor: pointer;
  transition: background 0.2s;
}
.checkout-btn:hover {
  background: #155ab6;
}
.empty-cart {
  text-align: center;
  color: #888;
  margin-top: 2rem;
}
</style>
