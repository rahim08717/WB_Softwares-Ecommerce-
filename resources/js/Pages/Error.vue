<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({ status: Number });

const title = {
    503: '503: Service Unavailable',
    500: '500: Server Error',
    404: '404: Page Not Found',
    403: '403: Forbidden',
}[props.status];

const description = {
    503: 'Sorry, we are doing some maintenance. Please check back soon.',
    500: 'Whoops, something went wrong on our servers.',
    404: 'Sorry, the page you are looking for could not be found.',
    403: 'Sorry, you are not authorized to access this page.',
}[props.status];
</script>

<template>
    <Head :title="title" />

    <ShopLayout>
        <div class="min-h-[60vh] flex flex-col items-center justify-center text-center px-4">
            <h1 class="text-6xl font-extrabold text-green-600 mb-4">{{ status }}</h1>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">{{ title }}</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-8">{{ description }}</p>

            <Link :href="route('home')" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-full transition shadow-lg">
                Go Back Home
            </Link>
        </div>
    </ShopLayout>
</template>
