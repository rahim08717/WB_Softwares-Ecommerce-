<script setup>
import { ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

const showingNavigationDropdown = ref(false);
const user = usePage().props.auth.user; // বর্তমান ইউজার
</script>

<template>
  <div class="min-h-screen bg-gray-100 flex">
    <aside class="w-64 bg-white shadow-md min-h-screen block">
      <div class="p-6 border-b">
        <h1 class="text-2xl font-bold text-gray-800">WB Admin</h1>
      </div>
      <nav class="mt-6 px-4 space-y-2">
        <Link
          :href="route('admin.dashboard')"
          :class="
            route().current('admin.dashboard')
              ? 'bg-gray-200 text-gray-900'
              : 'text-gray-600 hover:bg-gray-100'
          "
          class="block py-2.5 px-4 rounded transition duration-200"
        >
          Dashboard
        </Link>

        <Link
          :href="route('admin.categories.index')"
          :class="
            route().current('admin.categories.*')
              ? 'bg-gray-200 text-gray-900'
              : 'text-gray-600 hover:bg-gray-100'
          "
          class="block py-2.5 px-4 rounded transition duration-200"
        >
          Categories
        </Link>

        <Link
          :href="route('admin.products.index')"
          :class="
            route().current('admin.products.*')
              ? 'bg-gray-200 text-gray-900'
              : 'text-gray-600 hover:bg-gray-100'
          "
          class="block py-2.5 px-4 rounded transition duration-200"
        >
          Products
        </Link>

        <Link
          :href="route('admin.orders.index')"
          :class="
            route().current('admin.orders.*')
              ? 'bg-gray-200 text-gray-900'
              : 'text-gray-600 hover:bg-gray-100'
          "
          class="block py-2.5 px-4 rounded transition duration-200"
        >
          Orders
        </Link>

        <Link
          :href="route('admin.users.index')"
          :class="
            route().current('admin.users.*')
              ? 'bg-gray-200 text-gray-900'
              : 'text-gray-600 hover:bg-gray-100'
          "
          class="block py-2.5 px-4 rounded transition duration-200"
        >
          Users & Roles
        </Link>

        <Link
          :href="route('admin.settings.index')"
          :class="
            route().current('admin.settings.*')
              ? 'bg-indigo-600 text-white'
              : 'text-gray-300 hover:bg-slate-700'
          "
          class="flex items-center px-4 py-3 rounded-lg transition duration-200 mt-1"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 mr-3"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
            />
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
            />
          </svg>
          Settings
        </Link>
      </nav>
    </aside>

    <div class="flex-1 flex flex-col">
      <header class="bg-white shadow p-4 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">Admin Panel</h2>
        <div class="flex items-center space-x-4">
          <span class="text-gray-600">{{ user.name }}</span>
          <Link
            :href="route('logout')"
            method="post"
            as="button"
            class="text-red-500 hover:underline"
          >
            Logout
          </Link>
        </div>
      </header>

      <main class="flex-1 p-6">
        <slot />
      </main>
    </div>
  </div>
</template>
