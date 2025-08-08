<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import AppLogo from '../AppLogo.vue';
import DropdownMenu from '../ui/dropdown-menu/DropdownMenu.vue';
import { getInitials } from '@/composables/useInitials';
import UserMenuContent from '../UserMenuContent.vue';
import DropdownMenuContent from '../ui/dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuTrigger from '../ui/dropdown-menu/DropdownMenuTrigger.vue';
import Button from '../ui/button/Button.vue';
import Avatar from '../ui/avatar/Avatar.vue';
import AvatarImage from '../ui/avatar/AvatarImage.vue';
import AvatarFallback from '../ui/avatar/AvatarFallback.vue';

const page = usePage();
const auth = computed(() => page.props.auth);
const categories = page.props.mainCategories;

console.log(categories);
</script>

<template>
    <header class="flex items-center justify-between p-4 bg-white shadow">
        <AppLogo class="w-32">
            <router-link :to="{ name: 'home' }">
                <img src="/logo.png" alt="Logo" class="h-8" />
            </router-link>
        </AppLogo>
        <nav class="flex items-start flex-grow space-x-4 mx-8">
            <template v-for="parent in categories" :key="parent.id">
                <DropdownMenu v-if="parent.children_category && parent.children_category.length">
                    <DropdownMenuTrigger as-child>
                        <Button class="px-3 py-2 font-medium hover:bg-accent rounded" variant="ghost">
                            {{ parent.name }}
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent>
                        <a
                            v-for="child in parent.children_category"
                            :key="child.id"
                            :href="route('products.index', { id: child.name })"
                            class="block px-4 py-2 hover:bg-accent"
                        >
                            {{ child.name }}
                        </a>
                    </DropdownMenuContent>
                </DropdownMenu>
                <div v-else>
                    <a
                        :href="route('products.index', { id: parent.name })"
                        class="px-3 py-2 font-medium hover:bg-accent rounded"
                    >
                        {{ parent.name }}
                    </a>
                </div>
            </template>
        </nav>
        <DropdownMenu>
            <DropdownMenuTrigger :as-child="true">
                <Button
                    variant="ghost"
                    size="icon"
                    class="relative size-10 w-auto rounded-full p-1 focus-within:ring-2 focus-within:ring-primary"
                >
                    <Avatar class="size-8 overflow-hidden rounded-full">
                        <template v-if="$page.props.auth.user">
                        <AvatarImage v-if="auth.user.avatar" :src="auth.user.avatar" :alt="auth.user.name" />
                        <AvatarFallback class="rounded-lg bg-neutral-200 font-semibold text-black dark:bg-neutral-700 dark:text-white">
                            {{ getInitials(auth.user?.name) }}
                        </AvatarFallback>
                        </template>
                        <template v-else>
                            <AvatarImage :src="'/default-avatar.png'" :alt="'Guest'" />
                            <AvatarFallback class="rounded-lg bg-neutral-200 font-semibold text-black dark:bg-neutral-700 dark:text-white">
                                G
                            </AvatarFallback>
                        </template>
                    </Avatar>
                </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end" class="w-56">
                <template v-if="$page.props.auth.user">
                    <UserMenuContent :user="auth.user" />
                </template>
                <template v-else>
                    <a href="/login" class="block px-4 py-2 hover:bg-accent">Se connecter</a>
                    <a href="/register" class="block px-4 py-2 hover:bg-accent">S'inscrire</a>
                </template>
            </DropdownMenuContent>
        </DropdownMenu>
    </header>
</template>