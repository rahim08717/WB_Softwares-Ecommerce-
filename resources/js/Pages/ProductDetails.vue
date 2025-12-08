<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3'; // router ইম্পোর্ট করা হলো
import { ref } from 'vue';

const props = defineProps({
    product: Object
});

const quantity = ref(1);

const increment = () => {
    if (quantity.value < props.product.stock) quantity.value++;
};

const decrement = () => {
    if (quantity.value > 1) quantity.value--;
};

// ১. শুধু কার্টে যোগ করবে (পেজ চেঞ্জ হবে না)
const addToCart = () => {
    const form = useForm({
        product_id: props.product.id,
        quantity: quantity.value
    });

    form.post(route('cart.add'), {
        preserveScroll: true,
        onSuccess: () => {
            // ফ্ল্যাশ মেসেজ বা অ্যালার্ট দেখাতে পারো
            // alert('Added to cart');
        },
    });
};

// ২. কার্টে যোগ করে সরাসরি চেকআউট/কার্ট পেজে নিয়ে যাবে
const buyNow = () => {
    const form = useForm({
        product_id: props.product.id,
        quantity: quantity.value
    });

    form.post(route('cart.add'), {
        onSuccess: () => {
            // সফল হলে কার্ট পেজে নিয়ে যাবে
            router.visit(route('cart.index'));
        },
    });
};
</script>

<template>
    <Head :title="product.name" />

    <ShopLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <nav class="text-gray-400 text-sm mb-6 flex items-center gap-2">
                <Link :href="route('home')" class="hover:text-green-400">Home</Link>
                <span>/</span>
                <span class="text-green-500 font-medium">{{ product.name }}</span>
            </nav>

            <div class="bg-[#1f2937] rounded-2xl shadow-xl overflow-hidden border border-gray-700">
                <div class="md:flex">
                    <div class="md:w-1/2 bg-white p-8 flex items-center justify-center relative">
                        <img
                            v-if="product.image"
                            :src="'/storage/' + product.image"
                            :alt="product.name"
                            class="max-h-96 w-auto object-contain hover:scale-105 transition duration-500"
                        >
                        <div v-else class="h-64 flex flex-col items-center justify-center text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>No Image Available</span>
                        </div>
                    </div>

                    <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
                        <div class="uppercase tracking-wider text-xs font-bold text-green-400 mb-2">
                            {{ product.category?.name }}
                        </div>
                        <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-4">
                            {{ product.name }}
                        </h1>

                        <p class="text-3xl font-bold text-green-400 mb-6">${{ product.price }}</p>

                        <div class="prose prose-invert text-gray-400 mb-8">
                            <p>{{ product.description || 'No description provided for this product.' }}</p>
                        </div>

                        <div class="mb-8">
                            <span v-if="product.stock > 0" class="inline-flex items-center px-3 py-1 bg-green-900 text-green-300 rounded-full text-sm font-semibold border border-green-700">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                In Stock ({{ product.stock }} available)
                            </span>
                            <span v-else class="inline-flex items-center px-3 py-1 bg-red-900 text-red-300 rounded-full text-sm font-semibold border border-red-700">
                                Out of Stock
                            </span>
                        </div>

                        <div v-if="product.stock > 0" class="border-t border-gray-700 pt-8">
                            <div class="flex flex-col gap-4">

                                <div class="flex gap-4">
                                    <div class="flex items-center bg-gray-900 rounded-lg border border-gray-600 w-fit">
                                        <button @click="decrement" class="px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-l-lg transition">-</button>
                                        <input type="text" :value="quantity" readonly class="w-12 text-center bg-transparent border-none text-white focus:ring-0 p-0 font-bold">
                                        <button @click="increment" class="px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-r-lg transition">+</button>
                                    </div>

                                    <button
                                        @click="addToCart"
                                        class="flex-1 bg-transparent border-2 border-green-600 text-green-400 px-6 py-3 rounded-lg font-bold hover:bg-green-600 hover:text-white transition flex items-center justify-center gap-2"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Add to Cart
                                    </button>
                                </div>

                                <button
                                    @click="buyNow"
                                    class="w-full bg-green-600 text-white px-8 py-4 rounded-lg font-bold text-lg hover:bg-green-500 transition shadow-lg shadow-green-900/50 flex items-center justify-center gap-2 uppercase tracking-wide"
                                >
                                    Proceed to Checkout
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </ShopLayout>
</template>
