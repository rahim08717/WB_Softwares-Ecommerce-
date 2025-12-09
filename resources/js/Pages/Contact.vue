<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    subject: '',
    message: ''
});

const submit = () => {
    form.post(route('contact.store'), {
        onSuccess: () => form.reset()
    });
};
</script>

<template>
    <Head title="Contact Us" />

    <ShopLayout>
        <div class="max-w-4xl mx-auto px-4 py-12">
            <h1 class="text-3xl font-bold mb-8 text-gray-800 dark:text-white border-l-4 border-green-500 pl-4">Contact Us</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="space-y-6 text-gray-600 dark:text-gray-300">
                    <p>Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>

                    <div class="flex items-center gap-4">
                        <div class="bg-green-100 p-3 rounded-full text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 dark:text-white">Phone</h3>
                            <p>+880 1602-024545</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="bg-green-100 p-3 rounded-full text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 dark:text-white">Email</h3>
                            <p>support@wbshop.com</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
                    <form @submit.prevent="submit" class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-200">Name</label>
                            <input v-model="form.name" type="text" class="w-full border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-200">Email</label>
                            <input v-model="form.email" type="email" class="w-full border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-200">Subject</label>
                            <input v-model="form.subject" type="text" class="w-full border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-200">Message</label>
                            <textarea v-model="form.message" rows="4" class="w-full border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required></textarea>
                        </div>
                        <button type="submit" :disabled="form.processing" class="w-full bg-green-600 text-white font-bold py-2 rounded hover:bg-green-700 transition">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </ShopLayout>
</template>
