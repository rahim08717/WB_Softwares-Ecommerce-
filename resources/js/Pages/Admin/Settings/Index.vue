<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';

const props = defineProps({
    settings: Object // Controller থেকে আসা settings অবজেক্ট
});

// ফর্ম ইনিশিয়ালাইজ করা (আগের ডাটা দিয়ে)
const form = useForm({
    site_name: props.settings.site_name || '',
    site_email: props.settings.site_email || '',
    site_phone: props.settings.site_phone || '',
    site_address: props.settings.site_address || '',
    scrolling_text: props.settings.scrolling_text || '',
    facebook: props.settings.facebook || '',
    youtube: props.settings.youtube || '',
    logo: null, // ফাইল আপলোডের জন্য
});

const submit = () => {
    // ফাইল আপলোড আছে তাই post মেথড ব্যবহার করছি
    // forceFormData: true দিলে Inertia অটোমেটিক ফর্ম ডাটা হ্যান্ডেল করে
    router.post(route('admin.settings.update'), {
        _method: 'post',
        ...form,
        logo: form.logo,
    }, {
        onSuccess: () => alert('Settings Updated Successfully!')
    });
};
</script>

<template>
    <Head title="General Settings" />

    <AdminLayout>
        <div class="max-w-4xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">General Settings</h2>

            <div class="bg-white rounded-lg shadow p-6">
                <form @submit.prevent="submit" enctype="multipart/form-data">

                    <div class="mb-6 border-b pb-6">
                        <label class="block text-gray-700 font-bold mb-2">Website Logo</label>
                        <div class="flex items-center gap-4">
                            <div v-if="settings.logo" class="w-20 h-20 border rounded p-1">
                                <img :src="'/storage/' + settings.logo" class="w-full h-full object-contain">
                            </div>
                            <input type="file" @input="form.logo = $event.target.files[0]" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Site Name</label>
                            <input v-model="form.site_name" type="text" class="w-full border-gray-300 rounded focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Support Email</label>
                            <input v-model="form.site_email" type="email" class="w-full border-gray-300 rounded focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Phone Number</label>
                            <input v-model="form.site_phone" type="text" class="w-full border-gray-300 rounded focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Address</label>
                            <input v-model="form.site_address" type="text" class="w-full border-gray-300 rounded focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Scrolling Marquee Text (Offer)</label>
                        <textarea v-model="form.scrolling_text" rows="2" class="w-full border-gray-300 rounded focus:ring-blue-500" placeholder="🎉 Special Discount..."></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Facebook Link</label>
                            <input v-model="form.facebook" type="text" class="w-full border-gray-300 rounded focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">YouTube Link</label>
                            <input v-model="form.youtube" type="text" class="w-full border-gray-300 rounded focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 font-bold">
                            Save Changes
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </AdminLayout>
</template>
