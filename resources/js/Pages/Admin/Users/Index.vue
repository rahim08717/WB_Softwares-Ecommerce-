<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    users: Object, // Pagination Object
    roles: Array   // Available Roles ['admin', 'user']
});

// রোল চেঞ্জ করার ফাংশন
const changeRole = (userId, newRole) => {
    if(confirm(`Are you sure you want to change this user's role to ${newRole}?`)) {
        router.patch(route('admin.users.update-role', userId), {
            role: newRole
        }, {
            preserveScroll: true,
            onSuccess: () => alert('Role updated!')
        });
    } else {
        // যদি ক্যান্সেল করে, পেজ রিলোড দিয়ে আগের অবস্থায় আনো (UI ফিক্সের জন্য)
        router.reload();
    }
};

// ইউজার ডিলিট ফাংশন
const deleteUser = (userId) => {
    if(confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
        router.delete(route('admin.users.destroy', userId));
    }
};
</script>

<template>
    <Head title="User Management" />

    <AdminLayout>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">User & Role Management</h2>
            <span class="text-sm text-gray-500">Total Users: {{ users.total }}</span>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden border border-gray-200">
            <table class="w-full text-left whitespace-nowrap">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-4 font-bold text-gray-600">ID</th>
                        <th class="p-4 font-bold text-gray-600">Name</th>
                        <th class="p-4 font-bold text-gray-600">Email</th>
                        <th class="p-4 font-bold text-gray-600">Current Role</th>
                        <th class="p-4 font-bold text-gray-600">Change Role</th>
                        <th class="p-4 font-bold text-gray-600 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-50 transition">
                        <td class="p-4 text-gray-500">#{{ user.id }}</td>

                        <td class="p-4">
                            <div class="font-medium text-gray-900">{{ user.name }}</div>
                            <div class="text-xs text-gray-400">Joined: {{ new Date(user.created_at).toLocaleDateString() }}</div>
                        </td>

                        <td class="p-4 text-gray-600">{{ user.email }}</td>

                        <td class="p-4">
                            <span
                                v-if="user.roles[0]?.name === 'admin'"
                                class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-bold uppercase"
                            >
                                Admin
                            </span>
                            <span
                                v-else
                                class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold uppercase"
                            >
                                User
                            </span>
                        </td>

                        <td class="p-4">
                            <select
                                :value="user.roles[0]?.name"
                                @change="changeRole(user.id, $event.target.value)"
                                class="border-gray-300 rounded text-sm focus:ring-blue-500 focus:border-blue-500 cursor-pointer"
                            >
                                <option v-for="role in roles" :key="role" :value="role">
                                    {{ role.charAt(0).toUpperCase() + role.slice(1) }}
                                </option>
                            </select>
                        </td>

                        <td class="p-4 text-right">
                            <button
                                @click="deleteUser(user.id)"
                                class="text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-1 rounded transition"
                                title="Delete User"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AdminLayout>
</template>
