<script setup lang="ts">
import UserLayout from '@/layouts/user/UserHeaderLayout.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <UserLayout :breadcrumbs="breadcrumbs">
        <slot />
    </UserLayout>
</template>
