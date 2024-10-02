<script setup>
import { ref, onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios'; // Dodaj import axios

const posts = ref([]);

const fetchPosts = async () => {
    try {
        const response = await axios.get('/posts');
        posts.value = response.data;
    } catch (error) {
        console.error(error);
    }
};

onMounted(() => {
    fetchPosts();
});
</script>

<template>
    <Head title="Blog - Zocha Masters" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Blog - Zocha Masters
            </h2>
        </template>

        <div class="py-12">
            <div class="bg-slate-800 mx-auto max-w-7xl sm:px-6 lg:px-8 py-4">
                <div class="mb-6">
                    <h3 class="text-2xl font-semibold text-white">Posty</h3>
                </div>
                <div class="bg-slate-800 py-4 mb-6">
                        <button class="bg-green-500 hover:bg-green-700 text-white py-2 px-4 rounded">Dodaj post</button>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <div v-for="post in posts" :key="post.id" class="bg-slate-400 shadow-lg rounded-lg overflow-hidden">
                        <div class="p-6">
                            <h4 class="text-lg font-bold text-black-900">{{ post.title }}</h4>
                            <p class="text-black-700 mt-2">{{ post.excerpt }}</p>
                            <p class="text-gray-500 mt-2 text-sm">Dodano: {{ new Date(post.created_at).toLocaleDateString() }}</p>
                            <p class="text-gray-500 mt-2 text-sm">Autor: {{ post.user_id }}</p>
                            <div class="mt-4">
                                <a :href="`/post/${post.id}`" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                                    Wyświetl szczegóły
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
