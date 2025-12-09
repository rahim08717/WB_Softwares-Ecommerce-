<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({ page: Object });

const form = useForm({
    title: props.page.title,
    content: props.page.content,
    is_active: Boolean(props.page.is_active)
});

const submit = () => {
    form.put(route('admin.pages.update', props.page.id));
};
</script>

<template>
    <Head title="Edit Page" />
    <AdminLayout>
        <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-bold mb-4">Edit Page</h2>
            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Title</label>
                    <input v-model="form.title" type="text" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Content (HTML allowed)</label>
                    <textarea v-model="form.content" rows="10" class="w-full border p-2 rounded"></textarea>
                    <p class="text-xs text-gray-500 mt-1">You can write HTML here for formatting.</p>
                </div>
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" v-model="form.is_active" class="rounded border-gray-300 text-blue-600">
                        <span class="ml-2">Active</span>
                    </label>
                </div>
                <div class="flex justify-end gap-2">
                    <Link :href="route('admin.pages.index')" class="px-4 py-2 text-gray-600">Cancel</Link>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Page</button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
