<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    role: Object,
    permissions: Array
});

const form = useForm({
    name: props.role.name,
    permissions: props.role.permissions.map(p => p.name)
});


const permissionsGrouped = computed(() => {
    const groups = {};
    props.permissions.forEach(perm => {
        const groupName = perm.name.split('.')[0];
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

const isAllSelected = computed(() => {
    return props.permissions.length > 0 && form.permissions.length === props.permissions.length;
});

const submit = () => {
    form.put(route('admin.roles.update', props.role.id));
};
</script>

<template>
    <Head title="Edit Role" />
    <AdminLayout>
        <div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-md border border-gray-200">
            <div class="flex justify-between items-center mb-6 border-b pb-4">
                <h2 class="text-2xl font-bold text-gray-800">Edit Role: <span class="text-green-600">{{ role.name }}</span></h2>
                <Link :href="route('admin.roles.index')" class="text-gray-500 hover:text-gray-700">&larr; Back to Roles</Link>
            </div>

            <form @submit.prevent="submit">
                <div class="mb-8 max-w-md">
                    <label class="block mb-2 font-bold text-gray-700">Role Name</label>
                    <input v-model="form.name" type="text" class="w-full border-gray-300 rounded-lg p-3 focus:ring-green-500 focus:border-green-500 shadow-sm">
                    <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
                </div>

                <div class="mb-6">
                    <div class="flex justify-between items-center mb-4 bg-gray-50 p-3 rounded border">
                        <label class="font-bold text-lg text-gray-700">Manage Permissions</label>

                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                id="selectAll"
                                @change="selectAll"
                                :checked="isAllSelected"
                                class="w-5 h-5 text-green-600 rounded border-gray-300 focus:ring-green-500"
                            >
                            <label for="selectAll" class="ml-2 text-gray-700 font-semibold cursor-pointer">Select All Permissions</label>
                        </div>
                    </div>

                    <div class="grid gap-6">
                        <div v-for="(perms, groupName) in permissionsGrouped" :key="groupName" class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">

                            <div class="bg-gray-100 px-4 py-3 border-b flex justify-between items-center">
                                <h3 class="font-bold text-gray-800 capitalize text-md flex items-center gap-2">
                                    <span class="w-2 h-6 bg-green-500 rounded-full"></span>
                                    {{ groupName }} Permissions
                                </h3>
                                <div class="flex items-center bg-white px-3 py-1 rounded border">
                                    <input
                                        type="checkbox"
                                        :id="'group_' + groupName"
                                        @change="selectGroup(groupName, $event)"
                                        :checked="isGroupSelected(groupName)"
                                        class="w-4 h-4 text-green-600 rounded border-gray-300 focus:ring-green-500"
                                    >
                                    <label :for="'group_' + groupName" class="ml-2 text-sm text-gray-600 cursor-pointer select-none font-bold">Select Group</label>
                                </div>
                            </div>

                            <div class="p-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 bg-white">
                                <div v-for="perm in perms" :key="perm.id" class="flex items-center p-2 rounded hover:bg-green-50 transition cursor-pointer" @click="document.getElementById('perm_' + perm.id).click()">
                                    <input
                                        type="checkbox"
                                        :id="'perm_' + perm.id"
                                        :value="perm.name"
                                        v-model="form.permissions"
                                        @click.stop
                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                    >
                                    <label :for="'perm_' + perm.id" class="ml-2 text-sm text-gray-700 cursor-pointer select-none capitalize font-medium" @click.stop>
                                        {{ perm.name.split('.')[1] }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-6 border-t gap-4 sticky bottom-0 bg-white p-4 shadow-inner">
                    <Link :href="route('admin.roles.index')" class="px-6 py-3 border rounded-lg hover:bg-gray-100 text-gray-600">Cancel</Link>
                    <button type="submit" :disabled="form.processing" class="bg-green-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-green-700 transition shadow-lg flex items-center gap-2">
                        <svg v-if="form.processing" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Update Role
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
