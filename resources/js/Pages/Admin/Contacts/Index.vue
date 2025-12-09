<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({ messages: Object });

const deleteMessage = (id) => {
    if(confirm('Are you sure?')) router.delete(route('admin.contacts.destroy', id));
};
</script>

<template>
    <Head title="Messages" />
    <AdminLayout>
        <h2 class="text-xl font-bold mb-6 text-gray-800">Contact Messages</h2>
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="p-4">Name</th>
                        <th class="p-4">Subject</th>
                        <th class="p-4">Date</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="msg in messages.data" :key="msg.id" class="border-b hover:bg-gray-50">
                        <td class="p-4">
                            <div class="font-bold">{{ msg.name }}</div>
                            <div class="text-xs text-gray-500">{{ msg.email }}</div>
                        </td>
                        <td class="p-4">{{ msg.subject }}</td>
                        <td class="p-4 text-sm text-gray-500">{{ new Date(msg.created_at).toLocaleDateString() }}</td>
                        <td class="p-4">
                            <span v-if="msg.is_replied" class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Replied</span>
                            <span v-else class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Pending</span>
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <Link :href="route('admin.contacts.show', msg.id)" class="text-blue-600 hover:underline">View</Link>
                            <button @click="deleteMessage(msg.id)" class="text-red-600 hover:underline">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AdminLayout>
</template>
