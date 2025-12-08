<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

// প্রপস রিসিভ করা (যে ডাটা কন্ট্রোলার থেকে আসছে)
const props = defineProps({
    category: Object
});

// ফর্ম ইনিশিয়ালাইজ করা (আগের ভ্যালু দিয়ে)
const form = useForm({
    name: props.category.name,
    is_active: Boolean(props.category.is_active),
});

const submit = () => {
    // PUT মেথড ব্যবহার করে আপডেট রিকোয়েস্ট পাঠানো
    form.put(route('admin.categories.update', props.category.id));
};
</script>

<template>
    <Head title="Edit Category" />

    <AdminLayout>
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold mb-4">Edit Category</h2>

            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Category Name</label>
                    <input
                        v-model="form.name"
                        type="text"
                        class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"
                    >
                    <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
                </div>

                <div class="mb-4">
                    <label class="flex items-center">
                        <input
                            type="checkbox"
                            v-model="form.is_active"
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        >
                        <span class="ml-2 text-gray-700">Active</span>
                    </label>
                </div>

                <div class="flex items-center justify-between">
                    <Link :href="route('admin.categories.index')" class="text-gray-600 hover:underline">Cancel</Link>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50"
                    >
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
