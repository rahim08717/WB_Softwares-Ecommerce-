<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    products: Array,
    query: String
});
</script>

<template>
    <Head :title="'Search: ' + query" />

    <ShopLayout>
        <div class="max-w-7xl mx-auto px-4 py-12">
            <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">
                Search Results for "<span class="text-green-600">{{ query }}</span>"
            </h1>

            <div v-if="products.length > 0" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <Link
                    v-for="product in products"
                    :key="product.id"
                    :href="route('product.show', product.slug)"
                    class="group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm hover:shadow-xl transition duration-300 flex flex-col overflow-hidden"
                >
                    <div class="h-64 bg-gray-50 dark:bg-gray-700 flex items-center justify-center p-6 relative">
                        <img v-if="product.image" :src="'/storage/' + product.image" :alt="product.name" class="h-full w-full object-contain group-hover:scale-110 transition duration-500">
                        <div v-else class="text-gray-400">No Image</div>

                        <span v-if="product.old_price > product.price" class="absolute top-3 right-3 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded">
                            -{{ Math.round(((product.old_price - product.price) / product.old_price) * 100) }}%
                        </span>
                    </div>

                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white truncate mb-1 group-hover:text-green-500 transition">
                            {{ product.name }}
                        </h3>
                        <div class="mt-auto pt-4 flex items-center justify-between">
                            <div class="flex flex-col">
                                <span v-if="product.old_price" class="text-gray-400 text-sm line-through decoration-red-500">
                                    ${{ product.old_price }}
                                </span>
                                <span class="text-xl font-extrabold text-green-600">${{ product.price }}</span>
                            </div>
                            <button class="bg-green-600 text-white p-2.5 rounded-lg shadow hover:bg-green-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            </button>
                        </div>
                    </div>
                </Link>
            </div>

            <div v-else class="text-center py-20 bg-white dark:bg-gray-800 rounded-lg shadow">
                <p class="text-gray-500 dark:text-gray-300 text-lg">No products found matching your search.</p>
                <Link :href="route('home')" class="mt-4 inline-block text-green-600 hover:underline">Go Back Home</Link>
            </div>
        </div>
    </ShopLayout>
</template>
