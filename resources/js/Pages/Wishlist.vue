<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({
    wishlistItems: Array
});

const removeFromWishlist = (productId) => {
    if(confirm('Remove from wishlist?')) {
        router.post(route('wishlist.toggle'), { product_id: productId });
    }
};
</script>

<template>
    <Head title="My Wishlist" />

    <ShopLayout>
        <div class="max-w-7xl mx-auto px-4 py-12">
            <h1 class="text-3xl font-bold mb-8 text-gray-800 dark:text-white border-l-4 border-red-500 pl-4">
                My Wishlist
            </h1>

            <div v-if="wishlistItems.length > 0" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <div v-for="item in wishlistItems" :key="item.id" class="group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm hover:shadow-xl transition relative overflow-hidden">

                    <button @click="removeFromWishlist(item.product.id)" class="absolute top-2 right-2 bg-red-100 p-2 rounded-full text-red-600 hover:bg-red-600 hover:text-white z-10 transition" title="Remove">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <Link :href="route('product.show', item.product.slug)">
                        <div class="h-56 bg-gray-50 dark:bg-gray-700 flex items-center justify-center p-4">
                            <img v-if="item.product.image" :src="'/storage/' + item.product.image" :alt="item.product.name" class="h-full object-contain">
                            <div v-else class="text-gray-400">No Image</div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white truncate">{{ item.product.name }}</h3>
                            <p class="text-green-600 font-bold mt-2">${{ item.product.price }}</p>
                        </div>
                    </Link>
                </div>
            </div>

            <div v-else class="text-center py-20 bg-gray-50 dark:bg-gray-800 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                <h2 class="text-xl font-bold text-gray-600 dark:text-gray-300">Your wishlist is empty.</h2>
                <Link :href="route('home')" class="mt-4 inline-block text-green-600 hover:underline">Start Shopping</Link>
            </div>
        </div>
    </ShopLayout>
</template>
