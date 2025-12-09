<script setup>
import { Link, usePage, useForm, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage();
const user = computed(() => page.props.auth.user);
const cartCount = computed(() => page.props.cartCount || 0);
const wishlistCount = computed(() => page.props.wishlistCount || 0);

const allCategories = computed(() => page.props.categories || []);
const settings = computed(() => page.props.settings || {});

const visibleCategories = computed(() => allCategories.value.slice(0, 6));

const showUserDropdown = ref(false);
const showLangDropdown = ref(false);
const showMobileMenu = ref(false);

const isDarkMode = ref(false);
const toggleTheme = () => {
    isDarkMode.value = !isDarkMode.value;
    if (isDarkMode.value) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
};

const currentLang = computed(() => page.props.locale ? page.props.locale.toUpperCase() : 'EN');

const changeLang = (lang) => {
    window.location.href = route('lang.switch', lang);
};

const searchForm = useForm({ query: '' });
const submitSearch = () => {
    if (searchForm.query.trim()) {
        searchForm.get(route('search'));
    }
};

const visitCategory = (categoryName) => {
    router.get(route('search'), { query: categoryName });
};

const isAdmin = computed(() => {
    return user.value && user.value.roles && user.value.roles.some(role => role.name === 'admin');
});
</script>

<template>
    <div class="min-h-screen font-sans flex flex-col transition-colors duration-300"
         :class="[{'dark': isDarkMode}, isDarkMode ? 'bg-gray-900 text-gray-100' : 'bg-gray-50 text-gray-800']">

        <div class="py-2 px-4 text-xs font-medium z-50 relative"
             :class="isDarkMode ? 'bg-gray-800 text-gray-300 border-b border-gray-700' : 'bg-[#1f2937] text-white'">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-2">

                <div class="flex items-center gap-4 flex-shrink-0">
                    <span class="flex items-center gap-1 hover:text-green-400 cursor-pointer transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                        {{ settings.site_email || 'support@wbshop.com' }}
                    </span>
                    <span class="hidden md:flex items-center gap-1 hover:text-green-400 cursor-pointer transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                        {{ settings.site_phone || '+880 1602-024545' }}
                    </span>
                </div>

                <div class="flex-1 overflow-hidden w-full md:w-auto mx-4 relative h-4">
                    <div class="absolute whitespace-nowrap animate-marquee">
                        {{ settings.scrolling_text || '🎉 Welcome to WB Shop! Enjoy best quality products with free shipping on orders over 2000 BDT.' }}
                    </div>
                </div>

                <div class="flex items-center gap-4 flex-shrink-0">
                    <div class="relative">
                        <button @click="showLangDropdown = !showLangDropdown" class="flex items-center gap-1 hover:text-green-400 font-bold transition">
                            🌐 {{ currentLang }}
                        </button>
                        <div v-show="showLangDropdown" @click.away="showLangDropdown = false"
                             class="absolute right-0 mt-2 w-32 rounded shadow-lg z-50 py-1 border border-gray-200 dark:border-gray-700"
                             :class="isDarkMode ? 'bg-gray-800 text-white' : 'bg-white text-gray-800'">
                            <button @click="changeLang('en')" class="block w-full text-left px-4 py-2 hover:bg-green-600 hover:text-white transition">English</button>
                            <button @click="changeLang('bn')" class="block w-full text-left px-4 py-2 hover:bg-green-600 hover:text-white transition">Bangla</button>
                            <button @click="changeLang('hi')" class="block w-full text-left px-4 py-2 hover:bg-green-600 hover:text-white transition">Hindi</button>
                            <button @click="changeLang('es')" class="block w-full text-left px-4 py-2 hover:bg-green-600 hover:text-white transition">Spanish</button>
                            <button @click="changeLang('ur')" class="block w-full text-left px-4 py-2 hover:bg-green-600 hover:text-white transition">Urdu</button>
                        </div>
                    </div>

                    <button @click="toggleTheme" class="hover:text-yellow-400 transition" title="Toggle Theme">
                        <svg v-if="isDarkMode" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="py-4 shadow-md sticky top-0 z-40 transition-colors duration-300"
             :class="isDarkMode ? 'bg-gray-800 border-b border-gray-700' : 'bg-white'">
            <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-4">

                <Link :href="route('home')" class="flex items-center gap-2 flex-shrink-0">
                    <img v-if="settings.logo" :src="'/storage/' + settings.logo" alt="Logo" class="h-10 w-auto object-contain">
                    <div v-else class="flex items-center gap-2">
                        <div class="bg-green-600 p-2 rounded-full shadow-lg">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                        </div>
                        <h1 class="text-2xl font-bold tracking-wide" :class="isDarkMode ? 'text-white' : 'text-gray-900'">{{ settings.site_name || 'WB Shop' }}</h1>
                    </div>
                </Link>

                <div class="flex-1 w-full max-w-2xl mx-4">
                    <form @submit.prevent="submitSearch" class="relative flex w-full shadow-sm">
                        <input
                            v-model="searchForm.query"
                            type="text"
                            :placeholder="__('Search products...')"
                            class="w-full rounded-l-md py-3 px-4 focus:outline-none focus:ring-1 focus:ring-green-500 border"
                            :class="isDarkMode ? 'bg-gray-700 border-gray-600 text-white placeholder-gray-400' : 'bg-gray-100 border-gray-300 text-gray-900'"
                        >
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-r-md font-bold transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </button>
                    </form>
                </div>

                <div class="flex items-center gap-5 flex-shrink-0 justify-center md:justify-end w-full md:w-auto">

                    <Link :href="route('track.index')" class="relative flex flex-col items-center group transition" :title="__('Track Order')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 md:h-7 md:w-7 transition" :class="isDarkMode ? 'text-gray-300 group-hover:text-blue-400' : 'text-gray-600 group-hover:text-blue-600'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1" />
                        </svg>
                        <span class="text-[10px] md:text-xs mt-1 font-medium" :class="isDarkMode ? 'text-gray-400' : 'text-gray-600'">Track Order</span>
                    </Link>

                    <Link :href="route('wishlist.index')" class="relative flex flex-col items-center group transition" :title="__('Wishlist')">
                        <div class="relative p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 md:h-7 md:w-7 transition" :class="isDarkMode ? 'text-gray-300 group-hover:text-red-400' : 'text-gray-600 group-hover:text-red-500'" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px] font-bold w-4 h-4 flex items-center justify-center rounded-full shadow-sm">{{ wishlistCount }}</span>
                        </div>
                        <span class="text-[10px] md:text-xs mt-1 font-medium" :class="isDarkMode ? 'text-gray-400' : 'text-gray-600'">{{ __('Wishlist') }}</span>
                    </Link>

                    <Link :href="route('cart.index')" class="relative flex flex-col items-center group transition" :title="__('Cart')">
                        <div class="relative p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 md:h-7 md:w-7 transition" :class="isDarkMode ? 'text-gray-300 group-hover:text-green-400' : 'text-gray-600 group-hover:text-green-600'" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            <span class="absolute -top-1 -right-1 bg-green-600 text-white text-[10px] font-bold w-4 h-4 flex items-center justify-center rounded-full shadow-sm">{{ cartCount }}</span>
                        </div>
                        <span class="text-[10px] md:text-xs mt-1 font-medium" :class="isDarkMode ? 'text-gray-400' : 'text-gray-600'">{{ __('Cart') }}</span>
                    </Link>

                    <div v-if="user" class="relative">
                        <button @click="showUserDropdown = !showUserDropdown" class="flex flex-col items-center focus:outline-none group">
                            <div class="bg-gray-200 dark:bg-gray-700 rounded-full p-1 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :class="isDarkMode ? 'text-gray-300' : 'text-gray-600'" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <span class="text-[10px] md:text-xs mt-1 font-medium max-w-[80px] truncate" :class="isDarkMode ? 'text-gray-400' : 'text-gray-600'">{{ user.name }}</span>
                        </button>

                        <div v-show="showUserDropdown" @click.away="showUserDropdown = false"
                             class="absolute right-0 mt-3 w-48 rounded shadow-xl py-2 z-50 ring-1 ring-black ring-opacity-5 border border-gray-100 dark:border-gray-700"
                             :class="isDarkMode ? 'bg-gray-800 text-white' : 'bg-white text-gray-800'">
                            <Link v-if="isAdmin" :href="route('admin.dashboard')" class="block px-4 py-2 hover:bg-green-600 hover:text-white font-bold text-yellow-500">Admin Panel</Link>
                            <Link :href="route('dashboard')" class="block px-4 py-2 hover:bg-green-600 hover:text-white">{{ __('Dashboard') }}</Link>
                            <Link :href="route('profile.edit')" class="block px-4 py-2 hover:bg-green-600 hover:text-white">Profile</Link>
                            <Link :href="route('logout')" method="post" as="button" class="block w-full text-left px-4 py-2 text-red-500 hover:bg-red-600 hover:text-white">{{ __('Logout') }}</Link>
                        </div>
                        <div v-show="showUserDropdown" @click="showUserDropdown = false" class="fixed inset-0 z-40"></div>
                    </div>

                    <div v-else class="flex flex-col gap-1 text-xs font-bold">
                        <Link :href="route('login')" class="hover:text-green-500 transition" :class="isDarkMode ? 'text-white' : 'text-gray-800'">{{ __('Login') }}</Link>
                        <Link :href="route('register')" class="hover:text-green-500 transition" :class="isDarkMode ? 'text-white' : 'text-gray-800'">{{ __('Register') }}</Link>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-green-700 text-white shadow-md relative z-30">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex items-center justify-between h-12">
                    <button @click="showMobileMenu = !showMobileMenu" class="md:hidden p-2 text-white hover:bg-green-800 rounded transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </button>

                    <ul class="hidden md:flex items-center gap-6 text-[15px] font-semibold tracking-wide w-full">
                        <li><Link :href="route('home')" class="hover:text-green-200 transition block">HOME</Link></li>

                        <li v-for="category in visibleCategories" :key="category.id">
                            <button @click="visitCategory(category.name)" class="hover:text-green-200 transition block uppercase">
                                {{ category.name }}
                            </button>
                        </li>

                        <li class="ml-auto"><Link :href="route('contact.index')" class="hover:text-green-200 transition block uppercase">CONTACT US</Link></li>
                    </ul>
                </div>
            </div>

            <div v-show="showMobileMenu" class="md:hidden border-t border-green-600" :class="isDarkMode ? 'bg-gray-800' : 'bg-green-700'">
                <Link :href="route('home')" class="block px-4 py-3 border-b border-green-600 hover:bg-green-800 transition">HOME</Link>

                <button
                    v-for="cat in visibleCategories"
                    :key="cat.id"
                    @click="visitCategory(cat.name)"
                    class="block w-full text-left px-4 py-3 border-b border-green-600 hover:bg-green-800 transition uppercase"
                >
                    {{ cat.name }}
                </button>

                <Link :href="route('contact.index')" class="block px-4 py-3 border-b border-green-600 hover:bg-green-800 transition">CONTACT US</Link>
            </div>
        </div>

        <main class="flex-grow">
            <slot />
        </main>

        <footer class="pt-12 mt-auto" :class="isDarkMode ? 'bg-gray-950 text-gray-400 border-t border-gray-800' : 'bg-[#1f2937] text-gray-400'">
            <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">

                <div>
                    <div class="flex items-center gap-2 mb-4 text-white">
                        <span class="text-xl font-bold">{{ settings.site_name || 'WB Shop' }}</span>
                    </div>
                    <p class="text-sm mb-4 leading-relaxed">
                        Your trusted online shop. We provide the best quality products at affordable prices.
                    </p>
                    <div class="text-sm space-y-2">
                        <p class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ settings.site_address || 'Dhaka, Bangladesh' }}
                        </p>
                        <p class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            {{ settings.site_phone || '+880 1602-024545' }}
                        </p>
                    </div>
                </div>

                <div>
                    <h3 class="text-white font-bold text-lg mb-4 border-b border-gray-700 pb-2 inline-block">Information</h3>
                    <ul class="space-y-2 text-sm">
                        <li><Link :href="route('page.view', 'about-us')" class="hover:text-green-500 transition">About Us</Link></li>
                        <li><Link :href="route('page.view', 'delivery-info')" class="hover:text-green-500 transition">Delivery Info</Link></li>
                        <li><Link :href="route('page.view', 'privacy-policy')" class="hover:text-green-500 transition">Privacy Policy</Link></li>
                        <li><Link :href="route('page.view', 'terms-conditions')" class="hover:text-green-500 transition">Terms & Conditions</Link></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-bold text-lg mb-4 border-b border-gray-700 pb-2 inline-block">Customer Care</h3>
                    <ul class="space-y-2 text-sm">
                        <li><Link :href="route('contact.index')" class="hover:text-green-500 transition">Contact Us</Link></li>
                        <li><Link :href="route('page.view', 'returns-refunds')" class="hover:text-green-500 transition">Returns & Refunds</Link></li>
                        <li><a href="#" class="hover:text-green-500 transition">Site Map</a></li>
                        <li><a href="#" class="hover:text-green-500 transition">FAQ</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-bold text-lg mb-4 border-b border-gray-700 pb-2 inline-block">My Account</h3>
                    <ul class="space-y-2 text-sm mb-6">
                        <li v-if="!user"><Link :href="route('login')" class="hover:text-green-500 transition">{{ __('Login') }}</Link></li>
                        <li v-if="!user"><Link :href="route('register')" class="hover:text-green-500 transition">{{ __('Register') }}</Link></li>
                        <li v-if="user"><Link :href="route('dashboard')" class="hover:text-green-500 transition">{{ __('Dashboard') }}</Link></li>
                        <li v-if="user"><Link :href="route('track.index')" class="hover:text-green-500 transition">Order History</Link></li>
                    </ul>

                    <h4 class="text-white font-bold text-sm mb-3">Follow Us</h4>
                    <div class="flex space-x-3">
                        <a v-if="settings.facebook" :href="settings.facebook" target="_blank" class="bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700 transition"><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                        <a v-if="settings.youtube" :href="settings.youtube" target="_blank" class="bg-red-600 text-white p-2 rounded-full hover:bg-red-700 transition"><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg></a>
                    </div>
                </div>
            </div>

            <div class="text-center border-t border-gray-700 pt-8 pb-4 text-xs">
                &copy; 2025 {{ settings.site_name || 'WB Shop' }}. All Rights Reserved.
            </div>
        </footer>
    </div>
</template>

<style scoped>
@keyframes marquee { 0% { transform: translateX(100%); } 100% { transform: translateX(-100%); } }
.animate-marquee { animation: marquee 25s linear infinite; display: inline-block; }
</style>
