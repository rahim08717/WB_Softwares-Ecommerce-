<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({ message: Object });

const form = useForm({ reply_message: '' });

const sendReply = () => {
    form.post(route('admin.contacts.reply', props.message.id), {
        onSuccess: () => alert('Reply Sent!')
    });
};
</script>

<template>
    <Head title="Read Message" />
    <AdminLayout>
        <div class="max-w-4xl mx-auto">
            <Link :href="route('admin.contacts.index')" class="text-gray-500 hover:underline mb-4 inline-block">&larr; Back to Messages</Link>

            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h2 class="text-xl font-bold">{{ message.subject }}</h2>
                        <p class="text-gray-500 text-sm">From: {{ message.name }} ({{ message.email }})</p>
                    </div>
                    <span class="text-xs text-gray-400">{{ new Date(message.created_at).toLocaleString() }}</span>
                </div>
                <div class="bg-gray-50 p-4 rounded text-gray-700 whitespace-pre-wrap">
                    {{ message.message }}
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold mb-4">Send Reply</h3>
                <form @submit.prevent="sendReply">
                    <textarea v-model="form.reply_message" rows="5" class="w-full border rounded p-3 mb-4" placeholder="Write your reply here..." required></textarea>
                    <button type="submit" :disabled="form.processing" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Send Reply via Email
                    </button>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
