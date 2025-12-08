<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";

defineProps({
  products: Array,
});

const deleteProduct = (id) => {
  if (confirm("Are you sure you want to delete this product?")) {
    router.delete(route("admin.products.destroy", id));
  }
};
</script>

<template>
  <Head title="Products" />

  <AdminLayout>
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-xl font-semibold text-gray-800">Products</h2>
      <Link
        :href="route('admin.products.create')"
        class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700"
      >
        + Add Product
      </Link>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
      <table class="w-full text-left">
        <thead class="bg-gray-100 border-b">
          <tr>
             <th class="p-4 font-medium text-gray-600">SL</th>
            <th class="p-4 font-medium text-gray-600">Image</th>
            <th class="p-4 font-medium text-gray-600">Name</th>
            <th class="p-4 font-medium text-gray-600">Category</th>
            <th class="p-4 font-medium text-gray-600">Price</th>
            <th class="p-4 font-medium text-gray-600">Stock</th>
            <th class="p-4 font-medium text-gray-600 text-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="product in products"
            :key="product.id"
            class="border-b hover:bg-gray-50"
          >
           <td class="p-4 font-medium">{{ product.id }}</td>
            <td class="p-4">
              <img
                v-if="product.image"
                :src="'/storage/' + product.image"
                class="w-12 h-12 object-cover rounded"
                alt="Product Image"
              />
              <span v-else class="text-gray-400">No Image</span>
            </td>
            <td class="p-4 font-medium">{{ product.name }}</td>
            <td class="p-4 text-gray-600">{{ product.category?.name }}</td>
            <td class="p-4 font-bold">${{ product.price }}</td>
            <td class="p-4">{{ product.stock }}</td>
            <td class="p-4 text-right">
              <Link
                :href="route('admin.products.edit', product.id)"
                class="text-blue-600 hover:underline mr-3"
              >
                Edit
              </Link>

              <button
                @click="deleteProduct(product.id)"
                class="text-red-600 hover:underline"
              >
                Delete
              </button>
            </td>
          </tr>
          <tr v-if="products.length === 0">
            <td colspan="6" class="p-4 text-center text-gray-500">
              No products found.
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AdminLayout>
</template>
