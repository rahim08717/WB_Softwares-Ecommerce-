<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({ roles: Array });

const deleteRole = (id) => {
    if(confirm('Are you sure you want to delete this role?')) {
        router.delete(route('admin.roles.destroy', id));
    }
}
</script>

<template>
    <Head title="Roles Management" />

    <AdminLayout>
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Role Management</h2>
                <p class="text-sm text-gray-500">Manage user roles and their permissions.</p>
            </div>
            <Link :href="route('admin.roles.create')" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg shadow-md transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                Create New Role
            </Link>
        </div>

        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left whitespace-nowrap">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold tracking-wider">
                        <tr>
                            <th class="p-5 border-b border-gray-100">#</th>
                            <th class="p-5 border-b border-gray-100">Role Name</th>
                            <th class="p-5 border-b border-gray-100">Permissions</th>
                            <th class="p-5 border-b border-gray-100 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <tr v-for="(role, index) in roles" :key="role.id" class="hover:bg-gray-50 transition duration-150">

                            <td class="p-5 text-gray-500 font-medium">{{ index + 1 }}</td>

                            <td class="p-5">
                                <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-sm font-bold capitalize border border-blue-100">
                                    {{ role.name }}
                                </span>
                            </td>

                            <td class="p-5 max-w-md whitespace-normal">
                                <div class="flex flex-wrap gap-1">
                                    <span v-for="perm in role.permissions.slice(0, 5)" :key="perm.id" class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs border border-gray-200">
                                        {{ perm.name }}
                                    </span>

                                    <span v-if="role.permissions.length > 5" class="bg-gray-200 text-gray-700 px-2 py-0.5 rounded text-xs font-bold border border-gray-300">
                                        +{{ role.permissions.length - 5 }} more
                                    </span>

                                    <span v-if="role.permissions.length === 0" class="text-gray-400 text-xs italic">No permissions assigned</span>
                                </div>
                            </td>

                            <td class="p-5 text-right">
                                <div class="flex items-center justify-end gap-2">

                                    <Link
                                        :href="route('admin.roles.edit', role.id)"
                                        class="p-2 bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-100 border border-yellow-200 transition"
                                        title="Edit Role"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </Link>

                                    <button
                                        v-if="role.name !== 'super-admin'"
                                        @click="deleteRole(role.id)"
                                        class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 border border-red-200 transition"
                                        title="Delete Role"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>

                                    <button
                                        v-else
                                        disabled
                                        class="p-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed border border-gray-200"
                                        title="Cannot delete Super Admin"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </button>

                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="roles.length === 0" class="text-center py-12">
                <p class="text-gray-500">No roles found. Create a new one!</p>
            </div>
        </div>
    </AdminLayout>
</template>
