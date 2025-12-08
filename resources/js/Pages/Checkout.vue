<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({
    total: Number
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name, // অটোমেটিক নাম বসে যাবে
    email: user.email,
    phone: '',
    address: '',
    payment_method: 'cod', // ডিফল্ট Cash on Delivery
});

const submitOrder = () => {
    form.post(route('checkout.store'), {
        onSuccess: () => alert('Order Placed Successfully!'),
    });
};
</script>

<template>
    <Head title="Checkout" />

    <ShopLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl font-bold text-white mb-8 border-l-4 border-green-500 pl-4">Checkout</h1>

            <div class="flex flex-col lg:flex-row gap-8">

                <div class="lg:w-2/3">
                    <div class="bg-[#1f2937] p-8 rounded-xl shadow-lg border border-gray-700">
                        <h2 class="text-xl font-bold text-white mb-6">Shipping Information</h2>

                        <form @submit.prevent="submitOrder">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-gray-400 mb-2">Full Name</label>
                                    <input type="text" v-model="form.name" readonly class="w-full bg-gray-800 border border-gray-600 text-gray-400 rounded-lg p-3 cursor-not-allowed">
                                </div>
                                <div>
                                    <label class="block text-gray-400 mb-2">Email Address</label>
                                    <input type="text" v-model="form.email" readonly class="w-full bg-gray-800 border border-gray-600 text-gray-400 rounded-lg p-3 cursor-not-allowed">
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="block text-gray-400 mb-2">Phone Number</label>
                                <input type="text" v-model="form.phone" required placeholder="017xxxxxxxx" class="w-full bg-gray-900 border border-gray-600 text-white rounded-lg p-3 focus:ring-green-500 focus:border-green-500">
                                <div v-if="form.errors.phone" class="text-red-500 text-sm mt-1">{{ form.errors.phone }}</div>
                            </div>

                            <div class="mb-6">
                                <label class="block text-gray-400 mb-2">Delivery Address</label>
                                <textarea v-model="form.address" required rows="3" placeholder="House no, Road no, Area..." class="w-full bg-gray-900 border border-gray-600 text-white rounded-lg p-3 focus:ring-green-500 focus:border-green-500"></textarea>
                                <div v-if="form.errors.address" class="text-red-500 text-sm mt-1">{{ form.errors.address }}</div>
                            </div>

                            <div class="mb-8">
                                <h3 class="text-lg font-bold text-white mb-4">Payment Method</h3>
                                <div class="space-y-3">
                                    <label class="flex items-center p-4 border border-green-500 bg-green-900/20 rounded-lg cursor-pointer">
                                        <input type="radio" v-model="form.payment_method" value="cod" class="text-green-600 focus:ring-green-500">
                                        <span class="ml-3 text-white font-medium">Cash on Delivery</span>
                                    </label>
                                    <label class="flex items-center p-4 border border-gray-600 bg-gray-800 rounded-lg opacity-50 cursor-not-allowed">
                                        <input type="radio" value="online" disabled class="text-gray-500">
                                        <span class="ml-3 text-gray-400">Online Payment (Coming Soon)</span>
                                    </label>
                                </div>
                            </div>

                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="w-full bg-green-600 text-white font-bold py-4 rounded-lg hover:bg-green-500 transition shadow-lg shadow-green-900/50 uppercase tracking-wide disabled:opacity-50"
                            >
                                Place Order - ${{ total }}
                            </button>
                        </form>
                    </div>
                </div>

                <div class="lg:w-1/3">
                    <div class="bg-[#1f2937] p-6 rounded-xl shadow-lg border border-gray-700 sticky top-24">
                        <h2 class="text-lg font-bold text-white mb-4">Order Summary</h2>
                        <div class="flex justify-between mb-2 text-gray-400">
                            <span>Subtotal</span>
                            <span>${{ total }}</span>
                        </div>
                        <div class="flex justify-between mb-4 text-gray-400">
                            <span>Delivery Fee</span>
                            <span class="text-green-400">Free</span>
                        </div>
                        <div class="border-t border-gray-600 pt-4 flex justify-between items-center">
                            <span class="text-xl font-bold text-white">Total</span>
                            <span class="text-2xl font-bold text-green-400">${{ total }}</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-4 text-center">
                            By placing an order, you agree to our Terms and Conditions.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </ShopLayout>
</template>
