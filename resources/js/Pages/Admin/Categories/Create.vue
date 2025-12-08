<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
});

const submit = () => {
    form.post(route('admin.categories.store'));
};
</script>

<template>
    <Head title="Create Category" />

    <AdminLayout>
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold mb-4">Create New Category</h2>

            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Category Name</label>
                    <input
                        v-model="form.name"
                        type="text"
                        class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
                        placeholder="e.g. Electronics"
                    >
                    <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
                </div>

                <div class="flex items-center justify-between">
                    <Link :href="route('admin.categories.index')" class="text-gray-600 hover:underline">Cancel</Link>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50"
                    >
                        Save Category
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
