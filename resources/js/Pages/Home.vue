<script setup>
import ShopLayout from "@/Layouts/ShopLayout.vue";
import { Head, Link, router, useForm } from "@inertiajs/vue3";
import { ref, computed, onMounted, onUnmounted } from "vue";

const props = defineProps({
  products: Array,
  sliders: Array,
});

// --- SLIDER LOGIC ---
const currentSlide = ref(0);
const autoSlideInterval = ref(null);

const nextSlide = () => {
  if (props.sliders.length > 0) {
    currentSlide.value = (currentSlide.value + 1) % props.sliders.length;
  }
};

onMounted(() => {
  if (props.sliders.length > 1) {
    autoSlideInterval.value = setInterval(nextSlide, 3000);
  }
});

onUnmounted(() => {
  if (autoSlideInterval.value) clearInterval(autoSlideInterval.value);
});

// --- PRODUCT LOGIC (View More) ---
const visibleProductCount = ref(12);

const displayedProducts = computed(() => {
  return props.products.slice(0, visibleProductCount.value);
});

const loadMoreProducts = () => {
  visibleProductCount.value += 12;
};

// --- ADD TO CART (No Reload) ---
const addToCart = (product) => {
  router.post(route('cart.add'), {
    product_id: product.id,
    quantity: 1
  }, {
    preserveScroll: true,
    onSuccess: () => {
        // Toast message logic can go here
    }
  });
};

// --- WISHLIST TOGGLE ---
const toggleWishlist = (product) => {
  router.post(route('wishlist.toggle'), {
    product_id: product.id
  }, {
    preserveScroll: true,
  });
};

// --- CONTACT FORM LOGIC ---
const contactForm = useForm({
    name: '',
    email: '',
    subject: '',
    message: ''
});

const submitContact = () => {
    contactForm.post(route('contact.store'), {
        preserveScroll: true,
        onSuccess: () => {
            contactForm.reset();
            alert('Message Sent Successfully!');
        }
    });
};
</script>

<template>
  <Head title="Home" />

  <ShopLayout>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div v-if="sliders.length > 0" class="relative bg-gray-100 dark:bg-gray-900 rounded-2xl overflow-hidden shadow-lg h-[400px] md:h-[500px]">

            <div
                v-for="(slider, index) in sliders"
                :key="slider.id"
                class="absolute inset-0 transition-opacity duration-700 ease-in-out flex items-center justify-center"
                :class="{ 'opacity-100 z-10': currentSlide === index, 'opacity-0 z-0': currentSlide !== index }"
            >
                <div class="w-full h-full flex flex-col md:flex-row items-center justify-between px-6 md:px-16">
                    <div class="md:w-1/2 text-center md:text-left space-y-4 md:space-y-6 z-20 pt-10 md:pt-0 order-2 md:order-1">
                        <span v-if="slider.subtitle" class="text-green-600 font-bold tracking-wider uppercase bg-green-100 px-3 py-1 rounded-full text-xs md:text-sm">
                            {{ slider.subtitle }}
                        </span>
                        <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 dark:text-white leading-tight">
                            {{ slider.title }}
                        </h1>
                        <div class="pt-2">
                            <Link
                                :href="slider.link"
                                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 md:py-3 md:px-8 rounded-full shadow-lg transition transform hover:-translate-y-1 inline-flex items-center gap-2"
                            >
                                Shop Now
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </Link>
                        </div>
                    </div>

                    <div class="md:w-1/2 flex justify-center items-center h-full relative order-1 md:order-2">
                        <div class="absolute w-[280px] h-[280px] md:w-[400px] md:h-[400px] bg-green-200 dark:bg-green-900/50 rounded-full opacity-60 blur-3xl -z-10"></div>
                        <img
                            v-if="slider.product && slider.product.image"
                            :src="'/storage/' + slider.product.image"
                            alt="Product Image"
                            class="h-[200px] md:h-[380px] w-auto object-contain drop-shadow-2xl transition-transform duration-700 transform hover:scale-105"
                        >
                    </div>
                </div>
            </div>

            <div v-if="sliders.length > 1" class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2 z-30">
                <button
                    v-for="(slider, index) in sliders"
                    :key="index"
                    @click="currentSlide = index"
                    class="w-2 h-2 md:w-3 md:h-3 rounded-full transition-all duration-300"
                    :class="currentSlide === index ? 'bg-green-600 w-6 md:w-8' : 'bg-gray-400 hover:bg-green-400'"
                ></button>
            </div>
        </div>
    </div>

    <div id="products" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white border-l-4 border-green-500 pl-4">
                Latest Products
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <div
                v-for="product in displayedProducts"
                :key="product.id"
                class="group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm hover:shadow-xl transition duration-300 flex flex-col overflow-hidden relative"
            >
                <div class="h-64 bg-gray-50 dark:bg-gray-900/50 flex items-center justify-center p-6 relative">

                    <button
                        @click.prevent="toggleWishlist(product)"
                        class="absolute top-3 right-3 z-10 p-2 rounded-full bg-white dark:bg-gray-800 text-gray-400 hover:text-red-500 shadow-md transition transform hover:scale-110"
                        title="Add to Wishlist"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>

                    <Link :href="route('product.show', product.slug)" class="w-full h-full flex items-center justify-center">
                        <img
                            v-if="product.image"
                            :src="'/storage/' + product.image"
                            :alt="product.name"
                            class="h-full w-full object-contain group-hover:scale-110 transition duration-500"
                        >
                        <div v-else class="text-gray-400 text-sm">No Image</div>
                    </Link>

                    <span v-if="product.old_price > product.price" class="absolute top-3 left-3 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded shadow-sm">
                        -{{ Math.round(((product.old_price - product.price) / product.old_price) * 100) }}%
                    </span>
                </div>

                <div class="p-4 flex flex-col flex-grow">
                    <div class="flex justify-between items-start mb-3">
                        <Link :href="route('product.show', product.slug)" class="flex-1 mr-2">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white hover:text-green-600 dark:hover:text-green-400 transition line-clamp-2 leading-tight">
                                {{ product.name }}
                            </h3>
                        </Link>

                        <button
                            @click.prevent="addToCart(product)"
                            class="bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 p-2 rounded-full hover:bg-green-600 hover:text-white dark:hover:bg-green-600 dark:hover:text-white transition shadow-sm flex-shrink-0"
                            title="Add to Cart"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </button>
                    </div>

                    <div class="mt-auto flex items-center justify-between pt-2 border-t border-gray-100 dark:border-gray-700">
                        <div class="flex flex-col">
                            <span v-if="product.old_price > product.price" class="text-xs text-gray-400 line-through decoration-red-500">
                                ${{ product.old_price }}
                            </span>
                            <span class="text-xl font-bold text-green-600">${{ product.price }}</span>
                        </div>

                        <Link :href="route('product.show', product.slug)" class="text-xs font-bold text-gray-600 dark:text-gray-300 border border-gray-300 dark:border-gray-600 px-3 py-1.5 rounded hover:border-green-600 hover:text-green-600 dark:hover:text-green-400 transition">
                            View Details
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="visibleProductCount < products.length" class="text-center mt-12">
            <button
                @click="loadMoreProducts"
                class="bg-white dark:bg-gray-800 text-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 font-bold py-3 px-10 rounded-full hover:bg-gray-50 dark:hover:bg-gray-700 transition shadow-sm"
            >
                View More Products
            </button>
        </div>

        <div v-if="products.length === 0" class="text-center py-20 bg-gray-50 dark:bg-gray-800 rounded-lg mt-8">
            <p class="text-gray-500 dark:text-gray-400 text-lg">No products available at the moment.</p>
        </div>
    </div>

    <div class="bg-green-50 dark:bg-gray-900 py-16 border-t border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Get In Touch</h2>
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Have questions about our organic products? Send us a message and we'll reply as soon as possible.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-stretch">

                <div class="flex flex-col gap-6">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-start gap-4">
                        <div class="bg-green-100 p-3 rounded-full text-green-600 shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white text-lg">Call Us</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Mon-Fri from 8am to 8pm</p>
                            <p class="text-green-600 font-bold mt-1 text-lg">+880 1602-024545</p>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-start gap-4">
                        <div class="bg-green-100 p-3 rounded-full text-green-600 shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white text-lg">Email Us</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">We usually reply within 24 hours</p>
                            <p class="text-green-600 font-bold mt-1 text-lg">support@wbshop.com</p>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-start gap-4 flex-grow">
                        <div class="bg-green-100 p-3 rounded-full text-green-600 shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white text-lg">Visit Us</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed mt-1">
                                123, Green Road, Farmgate,<br>
                                Dhaka-1215, Bangladesh.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 h-full">
                    <form @submit.prevent="submitContact" class="space-y-5 h-full flex flex-col justify-center">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Name</label>
                                <input v-model="contactForm.name" type="text" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-3 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" placeholder="Your Name" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Email</label>
                                <input v-model="contactForm.email" type="email" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-3 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" placeholder="your@email.com" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Subject</label>
                            <input v-model="contactForm.subject" type="text" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-3 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" placeholder="How can we help?">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Message</label>
                            <textarea v-model="contactForm.message" rows="4" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-3 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" placeholder="Write your message here..." required></textarea>
                        </div>
                        <button type="submit" :disabled="contactForm.processing" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 rounded-lg transition shadow-md mt-auto">
                            Send Message
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

  </ShopLayout>
</template>
