<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({
    sliders: Array
});

const deleteSlider = (id) => {
    if(confirm('Are you sure you want to delete this slider?')) {
        router.delete(route('admin.sliders.destroy', id));
    }
};
</script>

<template>
    <Head title="Manage Sliders" />

    <AdminLayout>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Sliders</h2>
            <Link :href="route('admin.sliders.create')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Add New Slider
            </Link>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="p-4">Image</th>
                        <th class="p-4">Title / Subtitle</th>
                        <th class="p-4">Order</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="slider in sliders" :key="slider.id" class="border-b hover:bg-gray-50">
                        <td class="p-4">
                            <img :src="'/storage/' + slider.image" class="w-32 h-16 object-cover rounded border">
                        </td>
                        <td class="p-4">
                            <div class="font-bold">{{ slider.title || 'No Title' }}</div>
                            <div class="text-xs text-gray-500">{{ slider.subtitle }}</div>
                        </td>
                        <td class="p-4">{{ slider.order }}</td>
                        <td class="p-4">
                            <span v-if="slider.is_active" class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Active</span>
                            <span v-else class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded">Inactive</span>
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <Link :href="route('admin.sliders.edit', slider.id)" class="text-blue-600 hover:underline">Edit</Link>
                            <button @click="deleteSlider(slider.id)" class="text-red-600 hover:underline">Delete</button>
                        </td>
                    </tr>
                    <tr v-if="sliders.length === 0">
                        <td colspan="5" class="p-6 text-center text-gray-500">No sliders found.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AdminLayout>
</template>
