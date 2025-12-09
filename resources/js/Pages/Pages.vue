<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({ page: Object });
</script>

<template>
    <Head :title="page.title" />
    <ShopLayout>
        <div class="max-w-4xl mx-auto px-4 py-12">
            <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-white border-l-4 border-green-500 pl-4">
                {{ page.title }}
            </h1>

            <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 p-8 rounded-lg shadow"
                 v-html="page.content">
            </div>
        </div>
    </ShopLayout>
</template>
