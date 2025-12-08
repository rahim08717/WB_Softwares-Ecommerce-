<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    order: Object
});

const form = useForm({
    status: props.order.status,
    payment_status: props.order.payment_status
});

const updateStatus = () => {
    form.patch(route('admin.orders.update', props.order.id), {
        onSuccess: () => alert('Order updated successfully!')
    });
};
</script>

<template>
    <Head :title="'Order #' + order.id" />

    <AdminLayout>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-800">Order Details #{{ order.id }}</h2>
            <Link :href="route('admin.orders.index')" class="text-gray-600 hover:underline">Back to List</Link>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="font-bold text-lg mb-4 text-gray-700 border-b pb-2">Order Items</h3>
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-gray-500 text-sm">
                                <th class="pb-2">Product</th>
                                <th class="pb-2 text-center">Qty</th>
                                <th class="pb-2 text-right">Unit Price</th>
                                <th class="pb-2 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <tr v-for="item in order.items" :key="item.id">
                                <td class="py-3">
                                    <div class="font-medium text-gray-800">{{ item.product?.name }}</div>
                                </td>
                                <td class="py-3 text-center">{{ item.quantity }}</td>
                                <td class="py-3 text-right">${{ item.unit_price }}</td>
                                <td class="py-3 text-right font-bold">${{ (item.quantity * item.unit_price).toFixed(2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="mt-4 text-right border-t pt-4">
                        <span class="text-gray-600 mr-4">Total Amount:</span>
                        <span class="text-2xl font-bold text-gray-800">${{ order.total_price }}</span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="font-bold text-lg mb-4 text-gray-700 border-b pb-2">Shipping Information</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">Customer Name</p>
                            <p class="font-semibold">{{ order.user?.name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Email</p>
                            <p class="font-semibold">{{ order.user?.email }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-gray-500">Address & Phone</p>
                            <p class="font-semibold p-2 bg-gray-50 rounded mt-1">{{ order.address }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow h-fit">
                <h3 class="font-bold text-lg mb-4 text-gray-700 border-b pb-2">Update Status</h3>

                <form @submit.prevent="updateStatus" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Order Status</label>
                        <select v-model="form.status" class="w-full border-gray-300 rounded focus:ring-blue-500">
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
                        <select v-model="form.payment_status" class="w-full border-gray-300 rounded focus:ring-blue-500">
                            <option value="unpaid">Unpaid</option>
                            <option value="paid">Paid</option>
                        </select>
                    </div>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full bg-blue-600 text-white font-bold py-2 rounded hover:bg-blue-700 transition disabled:opacity-50"
                    >
                        Update Order
                    </button>
                </form>

                <div class="mt-6 text-xs text-gray-400">
                    Order created at: {{ new Date(order.created_at).toLocaleString() }}
                </div>
            </div>

        </div>
    </AdminLayout>
</template>
