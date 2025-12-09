<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    title: '',
    content: '',
    is_active: true
});

const submit = () => {
    form.post(route('admin.pages.store'));
};
</script>

<template>
    <Head title="Create Page" />

    <AdminLayout>
        <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-bold mb-4 text-gray-800">Create New Page</h2>

            <form @submit.prevent="submit">

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Page Title</label>
                    <input
                        v-model="form.title"
                        type="text"
                        class="w-full border border-gray-300 p-2 rounded focus:ring-blue-500 focus:border-blue-500"
                        placeholder="e.g. About Us"
                    >
                    <div v-if="form.errors.title" class="text-red-500 text-xs mt-1">{{ form.errors.title }}</div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Content (HTML allowed)</label>
                    <textarea
                        v-model="form.content"
                        rows="10"
                        class="w-full border border-gray-300 p-2 rounded focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Write your page content here..."
                    ></textarea>
                    <p class="text-xs text-gray-500 mt-1">You can use HTML tags for formatting (e.g. &lt;p&gt;, &lt;strong&gt;, &lt;ul&gt;).</p>
                    <div v-if="form.errors.content" class="text-red-500 text-xs mt-1">{{ form.errors.content }}</div>
                </div>

                <div class="mb-6">
                    <label class="flex items-center cursor-pointer">
                        <input
                            type="checkbox"
                            v-model="form.is_active"
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                        >
                        <span class="ml-2 text-gray-700 font-medium">Active</span>
                    </label>
                </div>

                <div class="flex justify-end gap-3">
                    <Link
                        :href="route('admin.pages.index')"
                        class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded transition border border-gray-300"
                    >
                        Cancel
                    </Link>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 font-bold transition disabled:opacity-50"
                    >
                        Create Page
                    </button>
                </div>

            </form>
        </div>
    </AdminLayout>
</template>
