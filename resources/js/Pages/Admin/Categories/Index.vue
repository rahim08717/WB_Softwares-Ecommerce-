<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
defineProps({
  categories: Array,
});

const deleteCategory = (id) => {
  if (confirm("Are you sure you want to delete this category?")) {
    router.delete(route("admin.categories.destroy", id));
  }
};
</script>

<template>
  <Head title="Categories" />

  <AdminLayout>
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-xl font-semibold text-gray-800">Categories</h2>
      <Link
        :href="route('admin.categories.create')"
        class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700"
      >
        + Add Category
      </Link>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
      <table class="w-full text-left">
        <thead class="bg-gray-100 border-b">
          <tr>
            <th class="p-4 font-medium text-gray-600">ID</th>
            <th class="p-4 font-medium text-gray-600">Name</th>
            <th class="p-4 font-medium text-gray-600">Slug</th>
            <th class="p-4 font-medium text-gray-600">Status</th>
            <th class="p-4 font-medium text-gray-600 text-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="category in categories"
            :key="category.id"
            class="border-b hover:bg-gray-50"
          >
            <td class="p-4">{{ category.id }}</td>
            <td class="p-4 font-medium">{{ category.name }}</td>
            <td class="p-4 text-gray-500">{{ category.slug }}</td>
            <td class="p-4">
              <span
                v-if="category.is_active"
                class="text-green-600 text-sm font-bold bg-green-100 px-2 py-1 rounded"
                >Active</span
              >
              <span
                v-else
                class="text-red-600 text-sm font-bold bg-red-100 px-2 py-1 rounded"
                >Inactive</span
              >
            </td>
            <td class="p-4 text-right">
              <Link
                :href="route('admin.categories.edit', category.id)"
                class="text-blue-600 hover:underline mr-3"
              >
                Edit
              </Link>

              <button
                @click="deleteCategory(category.id)"
                class="text-red-600 hover:underline"
              >
                Delete
              </button>
            </td>
          </tr>
          <tr v-if="categories.length === 0">
            <td colspan="5" class="p-4 text-center text-gray-500">
              No categories found.
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AdminLayout>
</template>
