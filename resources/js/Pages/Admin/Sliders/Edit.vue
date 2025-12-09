<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    slider: Object
});

const form = useForm({
    _method: 'put', // আপডেটের জন্য PUT মেথড
    title: props.slider.title,
    subtitle: props.slider.subtitle,
    image: null,
    link: props.slider.link,
    order: props.slider.order,
    is_active: Boolean(props.slider.is_active)
});

const submit = () => {
    // ইমেজ আপলোডসহ আপডেট করার জন্য post ব্যবহার করা হয়, সাথে _method: put
    form.post(route('admin.sliders.update', props.slider.id));
};
</script>

<template>
    <Head title="Edit Slider" />

    <AdminLayout>
        <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-bold mb-4">Edit Slider</h2>

            <form @submit.prevent="submit" enctype="multipart/form-data">

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Current Image</label>
                    <img :src="'/storage/' + slider.image" class="w-full h-32 object-cover rounded border">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">New Image (Optional)</label>
                    <input type="file" @input="form.image = $event.target.files[0]" class="w-full border p-2 rounded">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                        <input v-model="form.title" type="text" class="w-full border rounded p-2">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Subtitle</label>
                        <input v-model="form.subtitle" type="text" class="w-full border rounded p-2">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Button Link</label>
                        <input v-model="form.link" type="text" class="w-full border rounded p-2">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Sort Order</label>
                        <input v-model="form.order" type="number" class="w-full border rounded p-2">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" v-model="form.is_active" class="rounded border-gray-300 text-blue-600 shadow-sm">
                        <span class="ml-2 text-gray-700">Active</span>
                    </label>
                </div>

                <div class="flex justify-end gap-2">
                    <Link :href="route('admin.sliders.index')" class="px-4 py-2 text-gray-600 hover:underline">Cancel</Link>
                    <button type="submit" :disabled="form.processing" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Slider</button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
