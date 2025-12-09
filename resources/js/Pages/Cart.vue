<script setup>
import ShopLayout from "@/Layouts/ShopLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";

defineProps({
  cartItems: Array,
  total: Number,
});

const removeItem = (id) => {
  if (confirm("Are you sure you want to remove this item?")) {
    router.delete(route("cart.remove", id));
  }
};

const updateQuantity = (id, currentQty, change) => {
  const newQty = currentQty + change;

  if (newQty < 1) return;

  router.patch(
    route("cart.update", id),
    {
      quantity: newQty,
    },
    {
      preserveScroll: true, 
    }
  );
};
</script>

<template>
  <Head title="Shopping Cart" />

  <ShopLayout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <h1
        class="text-3xl font-bold text-white mb-8 border-l-4 border-green-500 pl-4"
      >
        Your Shopping Cart
      </h1>

      <div v-if="cartItems.length > 0" class="flex flex-col lg:flex-row gap-8">
        <div class="lg:w-2/3">
          <div
            class="bg-[#1f2937] rounded-xl shadow-lg border border-gray-700 overflow-hidden"
          >
            <table class="w-full text-left">
              <thead class="bg-gray-800 text-gray-400 uppercase text-xs">
                <tr>
                  <th class="px-6 py-4">Product</th>
                  <th class="px-6 py-4 text-center">Qty</th>
                  <th class="px-6 py-4 text-right">Price</th>
                  <th class="px-6 py-4"></th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-700">
                <tr
                  v-for="item in cartItems"
                  :key="item.id"
                  class="text-gray-300 hover:bg-gray-700/50 transition"
                >
                  <td class="px-6 py-4">
                    <div class="flex items-center gap-4">
                      <div
                        class="h-16 w-16 bg-white rounded flex-shrink-0 flex items-center justify-center"
                      >
                        <img
                          v-if="item.image"
                          :src="'/storage/' + item.image"
                          class="h-14 w-14 object-contain"
                        />
                      </div>
                      <div>
                        <div class="font-bold text-white text-lg">
                          {{ item.name }}
                        </div>
                        <div class="text-xs text-gray-500">
                          {{ item.category?.name }}
                        </div>
                        <div class="text-xs text-green-400 mt-1 font-semibold">
                          ${{ item.price }} / unit
                        </div>
                      </div>
                    </div>
                  </td>

                  <td class="px-6 py-4 text-center">
                    <div class="flex items-center justify-center gap-2">
                      <button
                        @click="updateQuantity(item.id, item.quantity, -1)"
                        class="w-8 h-8 rounded bg-gray-700 hover:bg-gray-600 text-white flex items-center justify-center transition disabled:opacity-50"
                        :disabled="item.quantity <= 1"
                      >
                        -
                      </button>

                      <span class="w-8 text-center font-bold text-white">{{
                        item.quantity
                      }}</span>

                      <button
                        @click="updateQuantity(item.id, item.quantity, 1)"
                        class="w-8 h-8 rounded bg-gray-700 hover:bg-gray-600 text-white flex items-center justify-center transition"
                      >
                        +
                      </button>
                    </div>
                  </td>

                  <td
                    class="px-6 py-4 text-right font-bold text-green-400 text-lg"
                  >
                    ${{ (item.price * item.quantity).toFixed(2) }}
                  </td>
                  <td class="px-6 py-4 text-right">
                    <button
                      @click="removeItem(item.id)"
                      class="p-2 text-red-400 hover:text-red-300 hover:bg-red-900/30 rounded-full transition"
                      title="Remove Item"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                        />
                      </svg>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="lg:w-1/3">
          <div
            class="bg-[#1f2937] rounded-xl shadow-lg border border-gray-700 p-6 sticky top-24"
          >
            <h2
              class="text-xl font-bold text-white mb-6 border-b border-gray-700 pb-2"
            >
              Order Summary
            </h2>

            <div class="flex justify-between mb-3 text-gray-400">
              <span>Subtotal</span>
              <span>${{ total.toFixed(2) }}</span>
            </div>
            <div class="flex justify-between mb-4 text-gray-400">
              <span>Shipping</span>
              <span class="text-green-400 text-sm">Free</span>
            </div>

            <div
              class="border-t border-gray-600 pt-4 flex justify-between items-center mb-8"
            >
              <span class="text-xl font-bold text-white">Total</span>
              <span class="text-3xl font-bold text-green-500"
                >${{ total.toFixed(2) }}</span
              >
            </div>

            <Link
              :href="route('checkout.index')"
              class="block w-full bg-green-600 ..."
            >
              Proceed to Checkout
            </Link>

            <Link
              :href="route('home')"
              class="block w-full text-center text-gray-400 mt-4 hover:text-white text-sm hover:underline"
            >
              Continue Shopping
            </Link>
          </div>
        </div>
      </div>

      <div
        v-else
        class="text-center py-20 bg-[#1f2937] rounded-xl border border-dashed border-gray-700"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-24 w-24 mx-auto text-gray-600 mb-6"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="1.5"
            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
          />
        </svg>
        <h2 class="text-2xl font-bold text-white mb-2">Your Cart is Empty</h2>
        <p class="text-gray-400 mb-8">
          Looks like you haven't added anything yet.
        </p>
        <Link
          :href="route('home')"
          class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-full font-bold hover:bg-green-500 transition"
        >
          Start Shopping
        </Link>
      </div>
    </div>
  </ShopLayout>
</template>
