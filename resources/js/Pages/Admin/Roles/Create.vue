<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({ permissions: Array });

const form = useForm({
    name: '',
    permissions: []
});


const permissionsGrouped = computed(() => {
    const groups = {};
    props.permissions.forEach(perm => {
        const groupName = perm.name.split('.')[0]; // 'product.create' -> 'product'
        if (!groups[groupName]) {
            groups[groupName] = [];
        }
        groups[groupName].push(perm);
    });
    return groups;
});

const selectAll = (e) => {
    if (e.target.checked) {
        form.permissions = props.permissions.map(p => p.name);
    } else {
        form.permissions = [];
    }
};

const selectGroup = (groupName, e) => {
    const groupPermissions = permissionsGrouped.value[groupName].map(p => p.name);

    if (e.target.checked) {
        form.permissions = [...new Set([...form.permissions, ...groupPermissions])];
    } else {
        form.permissions = form.permissions.filter(p => !groupPermissions.includes(p));
    }
};


const isGroupSelected = (groupName) => {
    const groupPermissions = permissionsGrouped.value[groupName].map(p => p.name);
    return groupPermissions.every(p => form.permissions.includes(p));
};

const submit = () => {
    form.post(route('admin.roles.store'));
};
</script>

<template>
    <Head title="Create Role" />
    <AdminLayout>
        <div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-md border border-gray-200">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4">Create New Role</h2>

            <form @submit.prevent="submit">
                <div class="mb-8 max-w-md">
                    <label class="block mb-2 font-bold text-gray-700">Role Name</label>
                    <input v-model="form.name" type="text" class="w-full border-gray-300 rounded-lg p-3 focus:ring-green-500 focus:border-green-500 shadow-sm" placeholder="e.g. Manager">
                    <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
                </div>

                <div class="mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <label class="font-bold text-lg text-gray-700">Permissions</label>

                        <div class="flex items-center">
                            <input type="checkbox" id="selectAll" @change="selectAll" class="w-5 h-5 text-green-600 rounded border-gray-300 focus:ring-green-500">
                            <label for="selectAll" class="ml-2 text-gray-700 font-semibold cursor-pointer">Select All Permissions</label>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div v-for="(perms, groupName) in permissionsGrouped" :key="groupName" class="border rounded-lg overflow-hidden shadow-sm">

                            <div class="bg-gray-100 px-4 py-3 border-b flex justify-between items-center">
                                <h3 class="font-bold text-gray-800 capitalize text-md">{{ groupName }} Management</h3>
                                <div class="flex items-center">
                                    <input
                                        type="checkbox"
                                        :id="'group_' + groupName"
                                        @change="selectGroup(groupName, $event)"
                                        :checked="isGroupSelected(groupName)"
                                        class="w-4 h-4 text-green-600 rounded border-gray-300 focus:ring-green-500"
                                    >
                                    <label :for="'group_' + groupName" class="ml-2 text-sm text-gray-600 cursor-pointer select-none">Select All</label>
                                </div>
                            </div>

                            <div class="p-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 bg-white">
                                <div v-for="perm in perms" :key="perm.id" class="flex items-center hover:bg-gray-50 p-2 rounded transition">
                                    <input
                                        type="checkbox"
                                        :id="'perm_' + perm.id"
                                        :value="perm.name"
                                        v-model="form.permissions"
                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                    >
                                    <label :for="'perm_' + perm.id" class="ml-2 text-sm text-gray-700 cursor-pointer select-none capitalize">
                                        {{ perm.name.split('.')[1] }} </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-6 border-t">
                    <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-green-700 transition shadow-lg">Save Role</button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
