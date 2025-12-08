<script setup>
import { Head } from '@inertiajs/vue3';

defineProps({
    order: Object
});

const printInvoice = () => {
    window.print();
};
</script>

<template>
    <Head :title="'Invoice #' + order.id" />

    <div class="bg-white text-gray-900 min-h-screen p-8 max-w-4xl mx-auto font-sans">
        <div class="mb-6 text-right no-print">
            <button @click="printInvoice" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Print / Download PDF
            </button>
        </div>

        <div class="flex justify-between items-center border-b pb-8 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">INVOICE</h1>
                <p class="text-sm text-gray-500">Order ID: #{{ order.id }}</p>
                <p class="text-sm text-gray-500">Date: {{ new Date(order.created_at).toLocaleDateString() }}</p>
            </div>
            <div class="text-right">
                <h2 class="text-2xl font-bold text-green-600">WB Shop</h2>
                <p class="text-sm text-gray-600">Dhaka, Bangladesh</p>
                <p class="text-sm text-gray-600">Email: support@wbshop.com</p>
            </div>
        </div>

        <div class="mb-8">
            <h3 class="font-bold text-gray-700 mb-2">Bill To:</h3>
            <p class="font-bold">{{ order.user.name }}</p>
            <p class="text-gray-600">{{ order.user.email }}</p>
            <p class="text-gray-600 mt-2 p-2 bg-gray-100 rounded">{{ order.address }}</p>
        </div>

        <table class="w-full mb-8 border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b border-gray-200 text-left">
                    <th class="py-3 px-4 font-semibold text-gray-600">Item</th>
                    <th class="py-3 px-4 font-semibold text-gray-600 text-center">Quantity</th>
                    <th class="py-3 px-4 font-semibold text-gray-600 text-right">Unit Price</th>
                    <th class="py-3 px-4 font-semibold text-gray-600 text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in order.items" :key="item.id" class="border-b border-gray-100">
                    <td class="py-3 px-4">{{ item.product?.name }}</td>
                    <td class="py-3 px-4 text-center">{{ item.quantity }}</td>
                    <td class="py-3 px-4 text-right">${{ item.unit_price }}</td>
                    <td class="py-3 px-4 text-right font-bold">${{ (item.quantity * item.unit_price).toFixed(2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="flex justify-end">
            <div class="w-64">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="font-bold">${{ order.total_price }}</span>
                </div>
                <div class="flex justify-between mb-4 border-b pb-2">
                    <span class="text-gray-600">Shipping</span>
                    <span class="font-bold text-green-600">Free</span>
                </div>
                <div class="flex justify-between text-xl font-bold">
                    <span>Total</span>
                    <span>${{ order.total_price }}</span>
                </div>
            </div>
        </div>

        <div class="mt-12 pt-8 border-t text-center text-gray-500 text-sm">
            <p>Thank you for your purchase!</p>
        </div>
    </div>
</template>

<style>
/* প্রিন্ট করার সময় বাটন লুকানোর জন্য */
@media print {
    .no-print {
        display: none;
    }
}
</style>
