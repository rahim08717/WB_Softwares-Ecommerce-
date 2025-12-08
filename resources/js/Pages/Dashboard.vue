<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

// Breeze এর ডিফল্ট কম্পোনেন্টগুলো ইম্পোর্ট করা জরুরি
import UpdateProfileInformationForm from '@/Pages/Profile/Partials/UpdateProfileInformationForm.vue';
import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm.vue';

const props = defineProps({
    orders: Array,
    status: String,
});

const activeTab = ref('orders'); // ডিফল্ট ট্যাব

const cancelOrder = (id) => {
    if(confirm('Are you sure you want to cancel this order?')) {
        router.post(route('orders.cancel', id));
    }
};
</script>

<template>
    <Head title="My Dashboard" />

    <ShopLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            <div class="flex flex-col md:flex-row justify-between items-center mb-8 border-b border-gray-700 pb-6">
                <h1 class="text-3xl font-bold text-white">My Dashboard</h1>

                <div class="flex space-x-4 mt-4 md:mt-0 bg-[#1f2937] p-1 rounded-lg">
                    <button
                        @click="activeTab = 'orders'"
                        :class="activeTab === 'orders' ? 'bg-green-600 text-white' : 'text-gray-400 hover:text-white'"
                        class="px-6 py-2 rounded-md font-medium transition"
                    >
                        My Orders
                    </button>
                    <button
                        @click="activeTab = 'settings'"
                        :class="activeTab === 'settings' ? 'bg-green-600 text-white' : 'text-gray-400 hover:text-white'"
                        class="px-6 py-2 rounded-md font-medium transition"
                    >
                        Account Settings
                    </button>
                </div>
            </div>

            <div v-if="activeTab === 'orders'" class="space-y-6">
                <div v-if="orders && orders.length > 0" class="space-y-6">
                    <div v-for="order in orders" :key="order.id" class="bg-[#1f2937] rounded-xl border border-gray-700 overflow-hidden shadow-lg">
                        <div class="bg-gray-800 p-4 flex flex-wrap justify-between items-center border-b border-gray-700 gap-4">
                            <div>
                                <span class="text-gray-400 text-sm block">Order #{{ order.id }}</span>
                                <span class="text-gray-500 text-xs">{{ new Date(order.created_at).toLocaleDateString() }}</span>
                            </div>

                            <div class="flex items-center gap-3">
                                <span
                                    :class="{
                                        'bg-yellow-900 text-yellow-300': order.status === 'pending',
                                        'bg-blue-900 text-blue-300': order.status === 'processing',
                                        'bg-green-900 text-green-300': order.status === 'completed',
                                        'bg-red-900 text-red-300': order.status === 'cancelled'
                                    }"
                                    class="px-3 py-1 rounded-full text-xs font-bold uppercase"
                                >
                                    {{ order.status }}
                                </span>

                                <a :href="route('orders.invoice', order.id)" target="_blank" class="text-sm bg-gray-700 hover:bg-gray-600 text-white px-3 py-1 rounded border border-gray-600 transition">
                                    Invoice
                                </a>

                                <button
                                    v-if="order.status === 'pending'"
                                    @click="cancelOrder(order.id)"
                                    class="text-sm bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded transition"
                                >
                                    Cancel
                                </button>
                            </div>
                        </div>

                        <div class="p-4">
                            <div v-for="item in order.items" :key="item.id" class="flex justify-between items-center py-2 border-b border-gray-700 last:border-0">
                                <div class="flex items-center gap-4">
                                    <div class="text-white font-medium">{{ item.product?.name }}</div>
                                    <div class="text-gray-500 text-sm">x {{ item.quantity }}</div>
                                </div>
                                <div class="text-white font-bold">${{ item.unit_price }}</div>
                            </div>
                        </div>

                        <div class="bg-gray-800 p-4 flex justify-between items-center">
                            <span class="text-gray-400">Total Amount</span>
                            <span class="text-xl font-bold text-green-400">${{ order.total_price }}</span>
                        </div>
                    </div>
                </div>

                <div v-else class="text-center py-20 bg-[#1f2937] rounded-xl border border-dashed border-gray-700">
                    <h2 class="text-xl text-white">No orders found.</h2>
                    <Link :href="route('home')" class="mt-4 inline-block text-green-400 hover:underline">Start Shopping</Link>
                </div>
            </div>

            <div v-if="activeTab === 'settings'" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-[#1f2937] p-6 rounded-xl border border-gray-700 shadow-lg">
                    <h3 class="text-lg font-bold text-white mb-4 border-b border-gray-600 pb-2">Profile Information</h3>
                    <div class="text-gray-300">
                        <UpdateProfileInformationForm :must-verify-email="false" :status="status" class="max-w-xl" />
                    </div>
                </div>

                <div class="bg-[#1f2937] p-6 rounded-xl border border-gray-700 shadow-lg">
                    <h3 class="text-lg font-bold text-white mb-4 border-b border-gray-600 pb-2">Change Password</h3>
                    <div class="text-gray-300">
                        <UpdatePasswordForm class="max-w-xl" />
                    </div>
                </div>
            </div>

        </div>
    </ShopLayout>
</template>
