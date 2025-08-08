<script lang="ts"></script>
<template>
    <ul>
        <li
            v-for="category in categories"
            :key="category.id"
            class="mb-1"
        >
            <div class="flex items-center justify-between w-full pr-2">
                <div class="flex items-center min-w-0" :style="{ marginLeft: `${level * 16}px` }">
                    <input
                        type="checkbox"
                        :value="category.id"
                        v-model="selectedCategories"
                    />
                    <span class="ml-2 truncate">{{ category.name }}</span>
                </div>
                <input
                    type="radio"
                    :value="category.id"
                    v-model="defaultCategory"
                    :disabled="!selectedCategories.includes(category.id)"
                />
            </div>
            <CategoryTree
                v-if="category.children && category.children.length"
                :categories="category.children"
                v-model:selectedCategories="selectedCategories"
                v-model:defaultCategory="defaultCategory"
                :level="level + 1"
            />
        </li>
    </ul>
</template>

<script setup lang="ts">
import { defineProps, defineEmits, computed } from 'vue';

const props = defineProps<{
  categories: Array<any>,
  selectedCategories: Array<number>,
  defaultCategory: number|null,
  level?: number
}>();
const emit = defineEmits(['update:selectedCategories', 'update:defaultCategory']);

const selectedCategories = computed({
  get: () => props.selectedCategories ?? [],
  set: val => emit('update:selectedCategories', val)
});
const defaultCategory = computed({
  get: () => props.defaultCategory,
  set: val => emit('update:defaultCategory', val)
});

// Pour l'indentation, par défaut 0
const level = props.level ?? 0;
</script>