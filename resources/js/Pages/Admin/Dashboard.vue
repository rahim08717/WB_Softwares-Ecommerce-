<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

// কন্ট্রোলার থেকে পাঠানো ডাটা রিসিভ করা
defineProps({
    totalOrders: Number,
    totalProducts: Number,
    totalRevenue: Number,
    recentOrders: Array
});
</script>

<template>
    <Head title="Admin Dashboard" />

    <AdminLayout>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
                <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Orders</h3>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ totalOrders || 0 }}</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
                <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Products</h3>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ totalProducts || 0 }}</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-purple-500">
                <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Revenue</h3>
                <p class="text-3xl font-bold text-gray-800 mt-2">${{ totalRevenue || 0 }}</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Recent Orders</h3>
                <Link :href="route('admin.orders.index')" class="text-sm text-blue-600 hover:underline">View All</Link>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left whitespace-nowrap">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-for="order in recentOrders" :key="order.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">#{{ order.id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ order.user?.name || 'Guest' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ new Date(order.created_at).toLocaleDateString() }}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    :class="{
                                        'bg-yellow-100 text-yellow-800': order.status === 'pending',
                                        'bg-green-100 text-green-800': order.status === 'completed',
                                        'bg-red-100 text-red-800': order.status === 'cancelled',
                                    }"
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full uppercase"
                                >
                                    {{ order.status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-800 text-right">
                                ${{ order.total_price }}
                            </td>
                        </tr>
                        <tr v-if="!recentOrders || recentOrders.length === 0">
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No orders found yet.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>
