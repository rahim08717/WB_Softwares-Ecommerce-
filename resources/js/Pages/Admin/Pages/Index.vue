<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({ pages: Array });

const deletePage = (id) => {
    if(confirm('Are you sure?')) router.delete(route('admin.pages.destroy', id));
};
</script>

<template>
    <Head title="Manage Pages" />
    <AdminLayout>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Pages</h2>
            <Link :href="route('admin.pages.create')" class="bg-blue-600 text-white px-4 py-2 rounded">+ Add Page</Link>
        </div>
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="p-4">Title</th>
                        <th class="p-4">Slug</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="page in pages" :key="page.id" class="border-b hover:bg-gray-50">
                        <td class="p-4 font-bold">{{ page.title }}</td>
                        <td class="p-4 text-gray-500">/{{ page.slug }}</td>
                        <td class="p-4">
                            <span v-if="page.is_active" class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Active</span>
                            <span v-else class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded">Inactive</span>
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <Link :href="route('admin.pages.edit', page.id)" class="text-blue-600 hover:underline">Edit</Link>
                            <button @click="deletePage(page.id)" class="text-red-600 hover:underline">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AdminLayout>
</template>
