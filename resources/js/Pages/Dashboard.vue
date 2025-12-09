<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import UpdateProfileInformationForm from '@/Pages/Profile/Partials/UpdateProfileInformationForm.vue';
import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm.vue';


import { Line } from 'vue-chartjs';
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend,
    Filler
} from 'chart.js';

ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend,
    Filler
);

const props = defineProps({
    orders: Array,
    status: String,
    auth: Object
});

const activeTab = ref('overview');

// --- STATS ---
const totalSpent = computed(() => {
    return props.orders.reduce((sum, order) => sum + parseFloat(order.total_price), 0).toFixed(2);
});

const completedOrders = computed(() => {
    return props.orders.filter(order => order.status === 'completed').length;
});

const pendingOrders = computed(() => {
    return props.orders.filter(order => order.status === 'pending').length;
});

const chartData = computed(() => {

    return {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
        datasets: [{
            label: 'Spending ($)',
            backgroundColor: 'rgba(16, 185, 129, 0.2)',
            pointBackgroundColor: '#10B981',
            pointBorderColor: '#fff',
            fill: true,
            data: [0, 50, 150, 80, 200, 120, parseFloat(totalSpent.value) || 0],
            tension: 0.4
        }]
    };
});

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: { display: false },
        tooltip: {
            backgroundColor: '#1F2937',
            titleColor: '#fff',
            bodyColor: '#fff',
            padding: 10,
            cornerRadius: 8,
            displayColors: false
        }
    },
    scales: {
        y: {
            beginAtZero: true,
            grid: { color: 'rgba(200, 200, 200, 0.1)' },
            ticks: { color: '#9CA3AF' }
        },
        x: {
            grid: { display: false },
            ticks: { color: '#9CA3AF' }
        }
    }
};

const cancelOrder = (id) => {
    if(confirm('Are you sure you want to cancel this order?')) {
        router.post(route('orders.cancel', id));
    }
};
</script>

<template>
    <Head title="My Dashboard" />

    <ShopLayout>
        <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8 md:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Dashboard</h1>
                        <p class="text-gray-500 dark:text-gray-400 mt-1">Welcome back, <span class="text-green-600 font-bold">{{ props.auth.user.name }}</span>!</p>
                    </div>

                    <div class="flex bg-white dark:bg-gray-800 p-1.5 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <button
                            v-for="tab in ['overview', 'orders', 'settings']"
                            :key="tab"
                            @click="activeTab = tab"
                            class="px-6 py-2 rounded-lg text-sm font-medium transition-all duration-300 capitalize"
                            :class="activeTab === tab
                                ? 'bg-green-600 text-white shadow-md transform scale-105'
                                : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'"
                        >
                            {{ tab }}
                        </button>
                    </div>
                </div>

                <div v-if="activeTab === 'overview'" class="space-y-8 animate-fade-in">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4 hover:shadow-md transition">
                            <div class="bg-green-100 dark:bg-green-900/30 p-4 rounded-full text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Spent</p>
                                <h3 class="text-3xl font-extrabold text-gray-800 dark:text-white">${{ totalSpent }}</h3>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4 hover:shadow-md transition">
                            <div class="bg-blue-100 dark:bg-blue-900/30 p-4 rounded-full text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Orders</p>
                                <h3 class="text-3xl font-extrabold text-gray-800 dark:text-white">{{ orders.length }}</h3>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4 hover:shadow-md transition">
                            <div class="bg-yellow-100 dark:bg-yellow-900/30 p-4 rounded-full text-yellow-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Pending</p>
                                <h3 class="text-3xl font-extrabold text-gray-800 dark:text-white">{{ pendingOrders }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white">Expense History</h3>
                            <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-md font-bold">Last 6 Months</span>
                        </div>

                        <div class="h-72 w-full relative">
                            <Line :data="chartData" :options="chartOptions" />
                        </div>
                    </div>
                </div>

                <div v-if="activeTab === 'orders'" class="space-y-6 animate-fade-in">
                    <div v-if="orders.length > 0" class="grid gap-6">
                        <div v-for="order in orders" :key="order.id" class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 transition hover:border-green-200 dark:hover:border-green-800">
                            <div class="flex flex-wrap justify-between items-center border-b border-gray-100 dark:border-gray-700 pb-4 mb-4">
                                <div>
                                    <h4 class="text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2">
                                        Order #{{ order.id }}
                                        <span class="text-xs font-normal text-gray-400 bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded">{{ new Date(order.created_at).toLocaleDateString() }}</span>
                                    </h4>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide"
                                        :class="{
                                            'bg-yellow-100 text-yellow-800': order.status === 'pending',
                                            'bg-blue-100 text-blue-800': order.status === 'processing',
                                            'bg-green-100 text-green-800': order.status === 'completed',
                                            'bg-red-100 text-red-800': order.status === 'cancelled'
                                        }"
                                    >
                                        {{ order.status }}
                                    </span>

                                    <a :href="route('orders.invoice', order.id)" target="_blank" class="bg-gray-100 dark:bg-gray-700 hover:bg-green-600 hover:text-white dark:hover:bg-green-600 text-gray-600 dark:text-gray-300 p-2 rounded-lg transition" title="Invoice">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    </a>

                                    <button
                                        v-if="order.status === 'pending'"
                                        @click="cancelOrder(order.id)"
                                        class="bg-red-50 dark:bg-red-900/20 hover:bg-red-600 hover:text-white text-red-600 p-2 rounded-lg transition"
                                        title="Cancel Order"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div v-for="item in order.items" :key="item.id" class="flex justify-between items-center text-sm">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 bg-gray-50 dark:bg-gray-700 rounded-lg flex items-center justify-center border border-gray-200 dark:border-gray-600">
                                            <img v-if="item.product?.image" :src="'/storage/' + item.product.image" class="w-full h-full object-cover rounded-lg">
                                            <span v-else class="text-xs text-gray-400">IMG</span>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800 dark:text-gray-200">{{ item.product?.name }}</p>
                                            <p class="text-xs text-gray-500">Qty: {{ item.quantity }}</p>
                                        </div>
                                    </div>
                                    <p class="font-bold text-gray-800 dark:text-white">${{ item.unit_price }}</p>
                                </div>
                            </div>

                            <div class="border-t border-gray-100 dark:border-gray-700 mt-4 pt-4 flex justify-between items-center">
                                <span class="text-xs text-gray-500 font-medium bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
                                    Payment: <span class="uppercase text-gray-700 dark:text-gray-300 font-bold">{{ order.payment_status }}</span>
                                </span>
                                <span class="text-xl font-extrabold text-green-600">${{ order.total_price }}</span>
                            </div>
                        </div>
                    </div>

                    <div v-else class="text-center py-24 bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-300 dark:border-gray-700">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-600 dark:text-gray-300">No orders yet</h2>
                        <p class="text-gray-500 text-sm mb-6">Looks like you haven't bought anything yet.</p>
                        <Link :href="route('home')" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transition">Start Shopping</Link>
                    </div>
                </div>

                <div v-if="activeTab === 'settings'" class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-fade-in">
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6 border-b border-gray-100 dark:border-gray-700 pb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            Profile Information
                        </h3>
                        <UpdateProfileInformationForm :must-verify-email="false" :status="status" class="max-w-full" />
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6 border-b border-gray-100 dark:border-gray-700 pb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            Change Password
                        </h3>
                        <UpdatePasswordForm class="max-w-full" />
                    </div>
                </div>

            </div>
        </div>
    </ShopLayout>
</template>

<style scoped>
.animate-fade-in {
    animation: fadeIn 0.5s ease-out;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
