<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue';
import { Head, Link, useForm, usePage, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    product: Object,
    relatedProducts: Array
});

const page = usePage();
const user = computed(() => page.props.auth.user);

const quantity = ref(1);
const activeTab = ref('description');

const increment = () => { if (quantity.value < props.product.stock) quantity.value++; };
const decrement = () => { if (quantity.value > 1) quantity.value--; };

const addToCart = () => {
    const form = useForm({
        product_id: props.product.id,
        quantity: quantity.value
    });
    form.post(route('cart.add'), {
        preserveScroll: true,
        onSuccess: () => alert('Product added to cart successfully!')
    });
};

const buyNow = () => {
    const form = useForm({
        product_id: props.product.id,
        quantity: quantity.value
    });

    form.post(route('cart.add'), {
        onSuccess: () => {
            router.visit(route('checkout.index'));
        }
    });
};

const reviewForm = useForm({
    product_id: props.product.id,
    rating: 5,
    comment: ''
});

const submitReview = () => {
    reviewForm.post(route('reviews.store'), {
        preserveScroll: true,
        onSuccess: () => {
            reviewForm.reset();
            alert('Review Submitted Successfully!');
        }
    });
};

const averageRating = computed(() => {
    if (props.product.reviews.length === 0) return 0;
    const total = props.product.reviews.reduce((acc, review) => acc + review.rating, 0);
    return Math.round(total / props.product.reviews.length);
});
</script>

<template>
    <Head :title="product.name" />

    <ShopLayout>
        <div class="max-w-7xl mx-auto px-4 py-8 md:py-12">

            <nav class="flex text-sm text-gray-500 dark:text-gray-400 mb-6">
                <Link :href="route('home')" class="hover:text-green-600">Home</Link>
                <span class="mx-2">/</span>
                <span class="text-gray-700 dark:text-gray-300 font-medium">{{ product.category?.name }}</span>
                <span class="mx-2">/</span>
                <span class="text-green-600 font-bold truncate">{{ product.name }}</span>
            </nav>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 mb-12">
                <div class="grid grid-cols-1 md:grid-cols-2">

                    <div class="p-6 md:p-10 bg-gray-50 dark:bg-gray-900 flex items-center justify-center relative group">
                        <img
                            v-if="product.image"
                            :src="'/storage/' + product.image"
                            :alt="product.name"
                            class="max-h-[400px] w-auto object-contain transition duration-500 group-hover:scale-105 drop-shadow-lg"
                        >
                        <div v-else class="text-gray-400 flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            <span class="mt-2 text-sm">No Image Available</span>
                        </div>

                        <span v-if="product.old_price > product.price" class="absolute top-6 left-6 bg-red-600 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-md animate-pulse">
                            -{{ Math.round(((product.old_price - product.price) / product.old_price) * 100) }}% OFF
                        </span>
                    </div>

                    <div class="p-6 md:p-10 flex flex-col justify-center">
                        <div class="mb-2">
                            <span class="text-green-600 bg-green-100 dark:bg-green-900 dark:text-green-300 px-2 py-1 rounded text-xs font-bold uppercase tracking-wider">
                                {{ product.category?.name }}
                            </span>
                        </div>

                        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white mb-2 leading-tight">
                            {{ product.name }}
                        </h1>

                        <div class="flex items-center gap-2 mb-6">
                            <div class="flex text-yellow-400">
                                <span v-for="n in 5" :key="n">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :class="n <= averageRating ? 'fill-current' : 'text-gray-300'" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </span>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">({{ product.reviews.length }} Reviews)</span>
                        </div>

                        <div class="flex items-end gap-3 mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                            <span class="text-4xl font-bold text-green-600">${{ product.price }}</span>
                            <div v-if="product.old_price > product.price" class="flex flex-col mb-1">
                                <span class="text-gray-400 text-lg line-through decoration-red-500">${{ product.old_price }}</span>
                            </div>
                        </div>

                        <p class="text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                            {{ product.description ? product.description.substring(0, 150) + '...' : 'No description available.' }}
                        </p>

                        <div class="mt-auto">
                            <div class="mb-4">
                                <span v-if="product.stock > 0" class="flex items-center text-green-600 font-bold text-sm">
                                    <span class="w-2.5 h-2.5 bg-green-500 rounded-full mr-2"></span>
                                    In Stock ({{ product.stock }} items)
                                </span>
                                <span v-else class="flex items-center text-red-500 font-bold text-sm">
                                    <span class="w-2.5 h-2.5 bg-red-500 rounded-full mr-2"></span>
                                    Out of Stock
                                </span>
                            </div>

                            <div v-if="product.stock > 0" class="flex flex-col sm:flex-row gap-4">
                                <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg h-12 w-fit">
                                    <button @click="decrement" class="px-4 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 h-full rounded-l-lg text-lg">-</button>
                                    <input type="text" :value="quantity" readonly class="w-12 text-center border-none bg-transparent text-gray-800 dark:text-white font-bold h-full p-0 focus:ring-0">
                                    <button @click="increment" class="px-4 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 h-full rounded-r-lg text-lg">+</button>
                                </div>

                                <button
                                    @click="addToCart"
                                    class="flex-1 h-12 border-2 border-green-600 text-green-600 hover:bg-green-600 hover:text-white dark:text-green-400 dark:hover:text-white font-bold rounded-lg transition flex items-center justify-center gap-2"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                    Add to Cart
                                </button>

                                <button
                                    @click="buyNow"
                                    class="flex-1 h-12 bg-green-600 text-white hover:bg-green-700 font-bold rounded-lg shadow-lg transition flex items-center justify-center gap-2 transform hover:-translate-y-0.5"
                                >
                                    Buy Now
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="flex border-b border-gray-200 dark:border-gray-700">
                            <button
                                @click="activeTab = 'description'"
                                class="flex-1 py-4 text-center font-bold text-sm uppercase tracking-wide transition border-b-2"
                                :class="activeTab === 'description' ? 'border-green-500 text-green-600 bg-green-50 dark:bg-gray-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700'"
                            >
                                Description
                            </button>
                            <button
                                @click="activeTab = 'reviews'"
                                class="flex-1 py-4 text-center font-bold text-sm uppercase tracking-wide transition border-b-2"
                                :class="activeTab === 'reviews' ? 'border-green-500 text-green-600 bg-green-50 dark:bg-gray-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700'"
                            >
                                Customer Reviews ({{ product.reviews.length }})
                            </button>
                        </div>

                        <div class="p-6 md:p-8">
                            <div v-if="activeTab === 'description'" class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 leading-relaxed">
                                <p>{{ product.description || 'No detailed description available for this product.' }}</p>
                            </div>

                            <div v-if="activeTab === 'reviews'">
                                <div v-if="product.reviews.length > 0" class="space-y-6 mb-10">
                                    <div v-for="review in product.reviews" :key="review.id" class="border-b border-gray-100 dark:border-gray-700 pb-6 last:border-0 last:pb-0">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center font-bold text-gray-600 uppercase">
                                                    {{ review.user.name.charAt(0) }}
                                                </div>
                                                <div>
                                                    <h4 class="font-bold text-gray-900 dark:text-white text-sm">{{ review.user.name }}</h4>
                                                    <div class="flex text-yellow-400 text-xs">
                                                        <span v-for="n in 5" :key="n">{{ n <= review.rating ? '★' : '☆' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="text-xs text-gray-400">{{ new Date(review.created_at).toLocaleDateString() }}</span>
                                        </div>
                                        <p class="text-gray-600 dark:text-gray-300 text-sm ml-13 pl-13">{{ review.comment }}</p>
                                    </div>
                                </div>
                                <div v-else class="text-center py-8 text-gray-500 italic bg-gray-50 dark:bg-gray-900 rounded-lg mb-8">
                                    No reviews yet. Be the first to review this product!
                                </div>

                                <div v-if="user" class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl border border-gray-200 dark:border-gray-600">
                                    <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">Write a Review</h3>
                                    <form @submit.prevent="submitReview">
                                        <div class="mb-4">
                                            <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Your Rating</label>
                                            <div class="flex gap-4">
                                                <label v-for="star in 5" :key="star" class="cursor-pointer">
                                                    <input type="radio" v-model="reviewForm.rating" :value="star" class="hidden">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 transition" :class="star <= reviewForm.rating ? 'text-yellow-400 fill-current' : 'text-gray-300'" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Your Review</label>
                                            <textarea v-model="reviewForm.comment" rows="3" class="w-full border rounded p-3 focus:ring-green-500 focus:border-green-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white" placeholder="What did you like or dislike?"></textarea>
                                        </div>
                                        <button type="submit" :disabled="reviewForm.processing" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 font-bold transition shadow-md disabled:opacity-50">
                                            Submit Review
                                        </button>
                                    </form>
                                </div>
                                <div v-else class="text-center p-6 bg-yellow-50 text-yellow-800 rounded-lg border border-yellow-200">
                                    Please <Link :href="route('login')" class="font-bold underline hover:text-yellow-900">Login</Link> to write a review.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-6 text-gray-800 dark:text-white border-l-4 border-green-500 pl-3">Related Products</h3>
                    <div class="space-y-4">
                        <Link
                            v-for="related in relatedProducts"
                            :key="related.id"
                            :href="route('product.show', related.slug)"
                            class="flex gap-4 bg-white dark:bg-gray-800 p-3 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition group"
                        >
                            <div class="w-20 h-20 bg-gray-50 dark:bg-gray-700 rounded-md flex-shrink-0 flex items-center justify-center">
                                <img v-if="related.image" :src="'/storage/' + related.image" class="h-full object-contain p-1 group-hover:scale-110 transition">
                                <span v-else class="text-xs text-gray-400">No Image</span>
                            </div>
                            <div class="flex flex-col justify-center">
                                <h4 class="font-bold text-gray-800 dark:text-white text-sm line-clamp-2 group-hover:text-green-600 transition">{{ related.name }}</h4>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-green-600 font-bold">${{ related.price }}</span>
                                    <span v-if="related.old_price > related.price" class="text-xs text-gray-400 line-through decoration-red-500">${{ related.old_price }}</span>
                                </div>
                            </div>
                        </Link>
                        <div v-if="relatedProducts.length === 0" class="text-gray-500 text-sm">No related products found.</div>
                    </div>
                </div>

            </div>

        </div>
    </ShopLayout>
</template>
