<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm, router } from "@inertiajs/vue3";

const props = defineProps({
  product: Object,
  categories: Array,
});

const form = useForm({
  _method: "PUT",
  name: props.product.name,
  category_id: props.product.category_id,
  price: props.product.price,
  old_price: props.product.old_price,
  stock: props.product.stock,
  description: props.product.description,
  old_price: props.product.old_price,
  image: null,
});

const submit = () => {
  form.post(route("admin.products.update", props.product.id));
};
</script>

<template>
  <Head title="Edit Product" />

  <AdminLayout>
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
      <h2 class="text-lg font-semibold mb-4">Edit Product</h2>

      <form @submit.prevent="submit" enctype="multipart/form-data">
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2"
            >Product Name</label
          >
          <input
            v-model="form.name"
            type="text"
            class="w-full border-gray-300 rounded focus:ring-blue-500"
          />
          <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">
            {{ form.errors.name }}
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2"
              >Category</label
            >
            <select
              v-model="form.category_id"
              class="w-full border-gray-300 rounded focus:ring-blue-500"
            >
              <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                {{ cat.name }}
              </option>
            </select>
          </div>
          <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2"
                >Sale Price (Active Price) *</label
              >
              <input
                v-model="form.price"
                type="number"
                step="0.01"
                class="w-full border-gray-300 rounded focus:ring-blue-500"
              />
              <div v-if="form.errors.price" class="text-red-500 text-xs mt-1">
                {{ form.errors.price }}
              </div>
            </div>
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2"
                >Regular Price (Old Price)</label
              >
              <input
                v-model="form.old_price"
                type="number"
                step="0.01"
                class="w-full border-gray-300 rounded focus:ring-blue-500"
                placeholder="Optional"
              />
              <div
                v-if="form.errors.old_price"
                class="text-red-500 text-xs mt-1"
              >
                {{ form.errors.old_price }}
              </div>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2"
              >Stock</label
            >
            <input
              v-model="form.stock"
              type="number"
              class="w-full border-gray-300 rounded focus:ring-blue-500"
            />
          </div>
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2"
              >Update Image (Optional)</label
            >
            <input
              type="file"
              @input="form.image = $event.target.files[0]"
              class="w-full text-sm text-gray-500"
            />
            <div v-if="product.image" class="mt-2 text-sm text-gray-500">
              Current:
              <a
                :href="'/storage/' + product.image"
                target="_blank"
                class="text-blue-500 underline"
                >View Image</a
              >
            </div>
          </div>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2"
            >Description</label
          >
          <textarea
            v-model="form.description"
            rows="3"
            class="w-full border-gray-300 rounded focus:ring-blue-500"
          ></textarea>
        </div>

        <div class="flex items-center justify-between mt-6">
          <Link
            :href="route('admin.products.index')"
            class="text-gray-600 hover:underline"
            >Cancel</Link
          >
          <button
            type="submit"
            :disabled="form.processing"
            class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50"
          >
            Update Product
          </button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>
