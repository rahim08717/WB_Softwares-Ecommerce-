<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    order: Object
});

const form = useForm({
    order_id: '',
    phone: ''
});

const submit = () => {
    form.post(route('track.search'), {
        preserveScroll: true,
        onSuccess: () => {

        }
    });
};
</script>

<template>
    <Head title="Track Your Order" />

    <ShopLayout>
        <div class="max-w-4xl mx-auto px-4 py-16">

            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Track Your Order</h1>
                <p class="text-gray-500 dark:text-gray-400">Enter your Order ID and Phone Number to track your delivery status.</p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 max-w-xl mx-auto">
                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Order ID</label>
                        <input
                            v-model="form.order_id"
                            type="text"
                            placeholder="e.g. 15"
                            class="w-full border rounded p-3 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            required
                        >
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Phone Number</label>
                        <input
                            v-model="form.phone"
                            type="text"
                            placeholder="e.g. 017xxxxxxxx"
                            class="w-full border rounded p-3 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            required
                        >
                    </div>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded transition shadow-md"
                    >
                        Track Order
                    </button>
                </form>
            </div>

            <div v-if="order" class="mt-12 bg-white dark:bg-gray-800 rounded-lg shadow-lg border-t-4 border-green-500 overflow-hidden animate-fade-in">

                <div class="bg-gray-50 dark:bg-gray-700 p-6 flex flex-wrap justify-between items-center border-b dark:border-gray-600">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Order #{{ order.id }}</h2>
                        <p class="text-sm text-gray-500">Placed on {{ new Date(order.created_at).toLocaleDateString() }}</p>
                    </div>
                    <div>
                        <span
                            class="px-4 py-2 rounded-full text-sm font-bold uppercase tracking-wide"
                            :class="{
                                'bg-yellow-100 text-yellow-800': order.status === 'pending',
                                'bg-blue-100 text-blue-800': order.status === 'processing',
                                'bg-green-100 text-green-800': order.status === 'completed',
                                'bg-red-100 text-red-800': order.status === 'cancelled'
                            }"
                        >
                            {{ order.status }}
                        </span>
                    </div>
                </div>

                <div class="p-8">
                    <div class="relative flex items-center justify-between text-sm text-gray-600 dark:text-gray-300 font-medium">
                        <div class="flex flex-col items-center z-10">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center mb-2 bg-green-600 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <span>Placed</span>
                        </div>

                        <div class="flex-1 h-1 mx-2" :class="['processing', 'completed'].includes(order.status) ? 'bg-green-600' : 'bg-gray-300'"></div>

                        <div class="flex flex-col items-center z-10">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center mb-2"
                                 :class="['processing', 'completed'].includes(order.status) ? 'bg-green-600 text-white' : 'bg-gray-300 text-gray-600'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                            </div>
                            <span>Processing</span>
                        </div>

                        <div class="flex-1 h-1 mx-2" :class="order.status === 'completed' ? 'bg-green-600' : 'bg-gray-300'"></div>

                        <div class="flex flex-col items-center z-10">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center mb-2"
                                 :class="order.status === 'completed' ? 'bg-green-600 text-white' : 'bg-gray-300 text-gray-600'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                            </div>
                            <span>Delivered</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 p-6 border-t dark:border-gray-600">
                    <h3 class="font-bold text-gray-800 dark:text-white mb-4">Order Items</h3>
                    <ul class="space-y-3">
                        <li v-for="item in order.items" :key="item.id" class="flex justify-between text-sm text-gray-600 dark:text-gray-300 border-b dark:border-gray-600 pb-2 last:border-0">
                            <span>{{ item.product?.name }} <span class="text-xs text-gray-500">x {{ item.quantity }}</span></span>
                            <span class="font-bold">${{ item.unit_price }}</span>
                        </li>
                    </ul>
                    <div class="mt-4 flex justify-between font-bold text-lg text-gray-800 dark:text-white border-t pt-4 dark:border-gray-600">
                        <span>Total</span>
                        <span class="text-green-600">${{ order.total_price }}</span>
                    </div>
                </div>

            </div>

        </div>
    </ShopLayout>
</template>

<style scoped>
.animate-fade-in {
    animation: fadeIn 0.5s ease-in;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
