<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link } from "@inertiajs/vue3";

defineProps({
  orders: Object, // Pagination Object
});
</script>

<template>
  <Head title="Manage Orders" />

  <AdminLayout>
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-xl font-semibold text-gray-800">Order Management</h2>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
      <table class="w-full text-left whitespace-nowrap">
        <thead class="bg-gray-100 border-b">
          <tr>
            <th class="p-4 font-medium text-gray-600">Order ID</th>
            <th class="p-4 font-medium text-gray-600">Customer</th>
            <th class="p-4 font-medium text-gray-600">Date</th>
            <th class="p-4 font-medium text-gray-600">Total</th>
            <th class="p-4 font-medium text-gray-600">Status</th>
            <th class="p-4 font-medium text-gray-600">Payment</th>
            <th class="p-4 font-medium text-gray-600 text-right">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <tr
            v-for="order in orders.data"
            :key="order.id"
            class="hover:bg-gray-50"
          >
            <td class="p-4">#{{ order.id }}</td>
            <td class="p-4 font-medium">{{ order.user?.name || "Guest" }}</td>
            <td class="p-4 text-gray-500">
              {{ new Date(order.created_at).toLocaleDateString() }}
            </td>
            <td class="p-4 font-bold text-gray-800">
              ${{ order.total_price }}
            </td>
            <td class="p-4">
              <span
                :class="{
                  'bg-yellow-100 text-yellow-800': order.status === 'pending',
                  'bg-blue-100 text-blue-800': order.status === 'processing',
                  'bg-green-100 text-green-800': order.status === 'completed',
                  'bg-red-100 text-red-800': order.status === 'cancelled',
                }"
                class="px-2 py-1 rounded-full text-xs font-bold uppercase"
              >
                {{ order.status }}
              </span>
            </td>
            <td class="p-4">
              <span
                :class="
                  order.payment_status === 'paid'
                    ? 'text-green-600'
                    : 'text-red-600'
                "
                class="font-bold text-xs uppercase"
              >
                {{ order.payment_status }}
              </span>
            </td>
            <td class="p-4 text-right">
              <Link
                :href="route('admin.orders.show', order.id)"
                class="bg-blue-600 text-white px-3 py-1.5 rounded text-sm hover:bg-blue-700"
              >
                View Details
              </Link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div
      class="mt-6 flex justify-center space-x-2"
      v-if="orders.links.length > 3"
    >
      <Link
        v-for="(link, k) in orders.links"
        :key="k"
        :href="link.url"
        class="px-3 py-1 border rounded"
        :class="
          link.active ? 'bg-blue-600 text-white' : 'bg-white text-gray-700'
        "
        :disabled="!link.url"
      >
        <span v-html="link.label"></span>
      </Link>
    </div>
  </AdminLayout>
</template>
