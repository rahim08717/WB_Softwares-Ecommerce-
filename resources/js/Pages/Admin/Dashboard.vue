<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

import { Bar, Doughnut } from 'vue-chartjs';
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
    ArcElement
} from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement);

const props = defineProps({
    totalOrders: Number,
    totalProducts: Number,
    totalRevenue: Number,
    recentOrders: Array,
    monthlyRevenue: Object,
    orderStats: Object
});

// --- BAR CHART DATA (Revenue) ---
const barChartData = computed(() => {
    const months = Object.keys(props.monthlyRevenue || {});
    const totals = Object.values(props.monthlyRevenue || {});

    return {
        labels: months.length ? months : ['No Data'],
        datasets: [{
            label: 'Revenue ($)',
            data: totals.length ? totals : [0],
            backgroundColor: '#10B981',
            borderRadius: 6,
            barThickness: 30
        }]
    };
});

const barOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: false } },
    scales: {
        y: { beginAtZero: true, grid: { color: '#f3f4f6' } },
        x: { grid: { display: false } }
    }
};

const doughnutChartData = computed(() => {
    return {
        labels: ['Pending', 'Processing', 'Completed', 'Cancelled'],
        datasets: [{
            data: [
                props.orderStats?.pending || 0,
                props.orderStats?.processing || 0,
                props.orderStats?.completed || 0,
                props.orderStats?.cancelled || 0
            ],
            backgroundColor: ['#F59E0B', '#3B82F6', '#10B981', '#EF4444'],
            borderWidth: 0,
            hoverOffset: 10
        }]
    };
});

const doughnutOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: { position: 'right', labels: { usePointStyle: true } }
    }
};
</script>

<template>
    <Head title="Admin Dashboard" />

    <AdminLayout>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500 flex justify-between items-center transition hover:shadow-md">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Total Orders</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ totalOrders }}</p>
                </div>
                <div class="p-3 bg-blue-50 rounded-full text-blue-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500 flex justify-between items-center transition hover:shadow-md">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Total Products</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ totalProducts }}</p>
                </div>
                <div class="p-3 bg-green-50 rounded-full text-green-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-purple-500 flex justify-between items-center transition hover:shadow-md">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Total Revenue</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">${{ totalRevenue }}</p>
                </div>
                <div class="p-3 bg-purple-50 rounded-full text-purple-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-8 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="text-lg font-bold text-gray-800">Recent Orders</h3>
                <Link :href="route('admin.orders.index')" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center gap-1">
                    View All <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </Link>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left whitespace-nowrap">
                    <thead>
                        <tr class="text-gray-500 bg-white border-b border-gray-100 text-xs uppercase tracking-wider">
                            <th class="px-6 py-3 font-semibold">Order ID</th>
                            <th class="px-6 py-3 font-semibold">Customer</th>
                            <th class="px-6 py-3 font-semibold">Date</th>
                            <th class="px-6 py-3 font-semibold">Status</th>
                            <th class="px-6 py-3 font-semibold text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="order in recentOrders" :key="order.id" class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-bold text-gray-800">#{{ order.id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ order.user?.name || 'Guest' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ new Date(order.created_at).toLocaleDateString() }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wide"
                                    :class="{
                                        'bg-yellow-100 text-yellow-700': order.status === 'pending',
                                        'bg-blue-100 text-blue-700': order.status === 'processing',
                                        'bg-green-100 text-green-700': order.status === 'completed',
                                        'bg-red-100 text-red-700': order.status === 'cancelled',
                                    }"
                                >
                                    {{ order.status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-800 text-right">${{ order.total_price }}</td>
                        </tr>
                        <tr v-if="recentOrders.length === 0">
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">No recent orders found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Monthly Revenue Analytics</h3>
                <div class="h-72 w-full">
                    <Bar :data="barChartData" :options="barOptions" />
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Order Status</h3>
                <div class="h-64 w-full flex justify-center items-center flex-grow">
                    <Doughnut :data="doughnutChartData" :options="doughnutOptions" />
                </div>
            </div>
        </div>

    </AdminLayout>
</template>
