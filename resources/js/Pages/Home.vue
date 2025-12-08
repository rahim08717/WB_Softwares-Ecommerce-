<script setup>
import ShopLayout from "@/Layouts/ShopLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3"; // router ইম্পোর্ট করো

defineProps({
  products: Array,
});

// কার্টে অ্যাড করার ফাংশন
const addToCart = (product) => {
  router.post(
    route("cart.add"),
    {
      product_id: product.id,
      quantity: 1,
    },
    {
      preserveScroll: true, // পেজ স্ক্রল যাতে না নড়ে
      onSuccess: () => {
        // চাইলে এখানে সুইট অ্যালার্ট বা টোস্ট মেসেজ দিতে পারো
        // alert('Added to cart!');
        console.log("Cart updated");
      },
    }
  );
};
</script>

<template>
  <Head title="Home" />

  <ShopLayout>
    <div class="bg-emerald-600 relative overflow-hidden">
      <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 text-center lg:text-left text-white relative z-10"
      >
        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight mb-4">
          Fresh & Quality <br />
          <span class="text-emerald-200">Products for You</span>
        </h1>
        <p class="mt-4 text-lg md:text-xl max-w-2xl text-emerald-100 mb-8">
          Get the best deals on our exclusive collection. Fast delivery and
          premium quality guaranteed.
        </p>
        <a
          href="#products"
          class="inline-block bg-white text-emerald-700 font-bold px-8 py-3 rounded-full shadow-lg hover:bg-gray-100 transition transform hover:-translate-y-1"
        >
          Shop Now
        </a>
      </div>
      <div
        class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-emerald-500 rounded-full opacity-50 blur-3xl"
      ></div>
    </div>

    <div id="products" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
      <div class="flex items-center justify-between mb-10">
        <h2
          class="text-2xl md:text-3xl font-bold text-gray-800 border-l-4 border-emerald-500 pl-4"
        >
          Latest Products
        </h2>
        <Link href="#" class="text-emerald-600 font-semibold hover:underline"
          >View All &rarr;</Link
        >
      </div>

      <div
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"
      >
        <Link
          v-for="product in products"
          :key="product.id"
          :href="route('product.show', product.slug)"
          class="group bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-xl transition duration-300 flex flex-col overflow-hidden"
        >
          <div
            class="h-64 bg-gray-50 flex items-center justify-center p-6 relative"
          >
            <img
              v-if="product.image"
              :src="'/storage/' + product.image"
              :alt="product.name"
              class="h-full w-full object-contain group-hover:scale-110 transition duration-500"
            />
            <div v-else class="text-gray-400 flex flex-col items-center">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-12 w-12 mb-2"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="1.5"
                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                />
              </svg>
              <span class="text-sm">No Image</span>
            </div>

            <span
              class="absolute top-3 left-3 bg-emerald-100 text-emerald-800 text-xs font-bold px-2 py-1 rounded"
            >
              {{ product.category?.name }}
            </span>
          </div>

          <div class="p-5 flex flex-col flex-grow">
            <h3
              class="text-lg font-bold text-gray-800 truncate mb-1 group-hover:text-emerald-600 transition"
            >
              {{ product.name }}
            </h3>

            <div class="mt-auto pt-4 flex items-center justify-between">
              <div>
                <span class="text-gray-400 text-xs block">Price</span>
                <span class="text-xl font-extrabold text-emerald-600"
                  >${{ product.price }}</span
                >
              </div>

              <button
                @click.prevent="addToCart(product)"
                class="bg-green-600 hover:bg-green-500 text-white p-2 rounded-lg transition shadow-lg z-20 relative"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-6 w-6"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                  />
                </svg>
              </button>
            </div>
          </div>
        </Link>
      </div>

      <div
        v-if="products.length === 0"
        class="text-center py-20 bg-gray-50 rounded-lg mt-8 border border-dashed border-gray-300"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-16 w-16 mx-auto text-gray-300 mb-4"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="1.5"
            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
          />
        </svg>
        <p class="text-gray-500 text-lg font-medium">No products found yet.</p>
        <p class="text-gray-400 text-sm">
          Please check back later or add products from admin panel.
        </p>
      </div>
    </div>
  </ShopLayout>
</template>
