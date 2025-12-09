<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    products: Array 
});

const form = useForm({
    product_id: '',
    title: '',
    subtitle: '',
    order: 0,
    is_active: true
});

const submit = () => {
    form.post(route('admin.sliders.store'));
};
</script>

<template>
    <Head title="Create Slider" />

    <AdminLayout>
        <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-bold mb-4">Add New Slider</h2>

            <form @submit.prevent="submit">

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Select Product *</label>
                    <select v-model="form.product_id" class="w-full border rounded p-2 focus:ring-blue-500" required>
                        <option value="" disabled>Choose a product...</option>
                        <option v-for="product in products" :key="product.id" :value="product.id">
                            {{ product.name }}
                        </option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">The slider image will be taken from this product automatically.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Custom Title (Optional)</label>
                        <input v-model="form.title" type="text" class="w-full border rounded p-2" placeholder="Defaults to Product Name">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Subtitle / Offer Text</label>
                        <input v-model="form.subtitle" type="text" class="w-full border rounded p-2" placeholder="e.g. Flat 20% Off">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Sort Order</label>
                        <input v-model="form.order" type="number" class="w-full border rounded p-2">
                    </div>
                    <div class="flex items-center mt-6">
                        <label class="flex items-center">
                            <input type="checkbox" v-model="form.is_active" class="rounded border-gray-300 text-blue-600 shadow-sm">
                            <span class="ml-2 text-gray-700">Active</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-2">
                    <Link :href="route('admin.sliders.index')" class="px-4 py-2 text-gray-600 hover:underline">Cancel</Link>
                    <button type="submit" :disabled="form.processing" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save Slider</button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
