<script setup>
import { ref, computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

const showingSidebar = ref(false);
const page = usePage();
const showSystemMenu = ref(false); // Dropdown Control

// সেফটি ইউজার ডেটা
const user = computed(() => page.props.auth?.user || { name: 'Admin', email: 'admin@example.com' });

// ১. প্রধান মেনু (Main Navigation)
const mainMenuItems = [
    { name: 'Dashboard', route: 'admin.dashboard', icon: 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z' },
    { name: 'Orders', route: 'admin.orders.index', icon: 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z' },
    { name: 'Products', route: 'admin.products.index', icon: 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4' },
    { name: 'Categories', route: 'admin.categories.index', icon: 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z' },
    { name: 'Messages', route: 'admin.contacts.index', icon: 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z' },
];

// ২. কনটেন্ট ম্যানেজমেন্ট (Sliders, Pages)
const contentMenuItems = [
    { name: 'Sliders', route: 'admin.sliders.index', icon: 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z' },
    { name: 'Pages', route: 'admin.pages.index', icon: 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z' },
];

// ৩. সিস্টেম ম্যানেজমেন্ট (Dropdown এর ভেতরের আইটেম)
const systemMenuItems = [
    { name: 'Users & Roles', route: 'admin.users.index' },
    { name: 'Roles & Perms', route: 'admin.roles.index' },
    { name: 'Settings', route: 'admin.settings.index' },
];
</script>

<template>
  <div class="min-h-screen bg-gray-100 flex font-sans">

    <div
        v-if="showingSidebar"
        @click="showingSidebar = false"
        class="fixed inset-0 z-20 bg-black opacity-50 transition-opacity lg:hidden"
    ></div>

    <aside
        :class="showingSidebar ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
        class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 transform bg-[#1f2937] overflow-y-auto lg:translate-x-0 lg:static lg:inset-0 shadow-2xl flex flex-col"
    >
        <div class="h-16 flex items-center justify-center border-b border-gray-700 bg-gray-900 flex-shrink-0">
            <span class="text-white text-xl font-bold tracking-wider">WB <span class="text-green-500">Admin</span></span>
        </div>

        <nav class="flex-1 px-3 py-6 space-y-6">

            <div>
                <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Main Menu</p>
                <div class="space-y-1">
                    <template v-for="item in mainMenuItems" :key="item.name">
                        <Link
                            v-if="route().has(item.route)"
                            :href="route(item.route)"
                            :class="route().current(item.route + '*')
                                ? 'bg-gray-800 text-white border-l-4 border-green-500 shadow-md'
                                : 'text-gray-400 hover:bg-gray-800 hover:text-white border-l-4 border-transparent'"
                            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-r-md transition-all duration-200"
                        >
                            <svg class="mr-3 h-5 w-5 flex-shrink-0" :class="route().current(item.route + '*') ? 'text-green-500' : 'text-gray-500 group-hover:text-gray-300'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="item.icon" />
                            </svg>
                            {{ item.name }}
                        </Link>
                    </template>
                </div>
            </div>

            <div>
                <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Content</p>
                <div class="space-y-1">
                    <template v-for="item in contentMenuItems" :key="item.name">
                        <Link
                            v-if="route().has(item.route)"
                            :href="route(item.route)"
                            :class="route().current(item.route + '*')
                                ? 'bg-gray-800 text-white border-l-4 border-green-500 shadow-md'
                                : 'text-gray-400 hover:bg-gray-800 hover:text-white border-l-4 border-transparent'"
                            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-r-md transition-all duration-200"
                        >
                            <svg class="mr-3 h-5 w-5 flex-shrink-0" :class="route().current(item.route + '*') ? 'text-green-500' : 'text-gray-500 group-hover:text-gray-300'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="item.icon" />
                            </svg>
                            {{ item.name }}
                        </Link>
                    </template>
                </div>
            </div>

            <div>
                <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">System</p>

                <button
                    @click="showSystemMenu = !showSystemMenu"
                    class="w-full group flex items-center justify-between px-3 py-2.5 text-sm font-medium rounded-r-md text-gray-400 hover:bg-gray-800 hover:text-white border-l-4 border-transparent focus:outline-none"
                    :class="{'bg-gray-800 text-white': showSystemMenu}"
                >
                    <div class="flex items-center">
                        <svg class="mr-3 h-5 w-5 text-gray-500 group-hover:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Administration
                    </div>
                    <svg class="h-4 w-4 transition-transform duration-200" :class="{'rotate-180': showSystemMenu}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div v-show="showSystemMenu" class="mt-1 space-y-1 pl-10">
                    <template v-for="item in systemMenuItems" :key="item.name">
                        <Link
                            v-if="route().has(item.route)"
                            :href="route(item.route)"
                            :class="route().current(item.route + '*')
                                ? 'text-green-400 font-bold'
                                : 'text-gray-400 hover:text-white'"
                            class="group flex items-center py-2 text-sm transition-all duration-200"
                        >
                            {{ item.name }}
                        </Link>
                    </template>
                </div>
            </div>

        </nav>

        <div class="p-4 border-t border-gray-700">
            <Link :href="route('logout')" method="post" as="button" class="flex items-center text-red-400 hover:text-red-300 text-sm font-medium w-full">
                <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Sign Out
            </Link>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">

        <header class="flex justify-between items-center py-4 px-6 bg-white shadow-sm border-b border-gray-200 z-10">
            <div class="flex items-center">
                <button @click="showingSidebar = true" class="text-gray-500 focus:outline-none lg:hidden p-2 rounded-md hover:bg-gray-100">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h11" /></svg>
                </button>
                <h2 class="text-xl font-semibold text-gray-800 ml-4 lg:ml-0 hidden sm:block">Dashboard</h2>
            </div>

            <div class="flex items-center space-x-4">
                <a :href="route('home')" target="_blank" class="hidden md:flex items-center text-sm font-bold text-gray-500 hover:text-green-600 transition bg-gray-100 px-3 py-2 rounded-full">
                    <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                    View Shop
                </a>

                <div class="flex items-center gap-3 pl-4 border-l border-gray-200">
                    <div class="text-right hidden md:block">
                        <div class="text-sm font-bold text-gray-800">{{ user.name }}</div>
                        <div class="text-xs text-gray-500">Admin</div>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold text-lg border border-green-200">
                        {{ user.name.charAt(0).toUpperCase() }}
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
            <slot />
        </main>
    </div>
  </div>
</template>
