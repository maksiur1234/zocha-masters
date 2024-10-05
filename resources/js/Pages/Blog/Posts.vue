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
                    <a href="/add-post" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
                        Dodaj post
                    </a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <div v-for="post in posts" :key="post.id" class="bg-slate-400 shadow-lg rounded-lg overflow-hidden">
                        <div class="p-6">
                            <h4 class="text-lg font-bold text-black-900">{{ post.title }}</h4>
                            <p class="text-black-700 mt-2">{{ post.excerpt }}</p>
                            <p class="text-gray-500 mt-2 text-sm">Dodano: {{ post.created_at }}</p>
                            <p class="text-gray-500 mt-2 text-sm">Autor: {{ post.user_id }}</p>
                            <div class="mt-4 flex space-x-2">
                                <a :href="`/post/${post.id}`" class="m-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded flex items-center space-x-1">
                                    <i class="fas fa-eye"></i>
                                    <span>Wyświetl</span>
                                </a>

                                <a v-if="post.user_id === user.id" :href="`/post/${post.id}/edit`" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded flex items-center space-x-1">
                                    <i class="fas fa-edit"></i>
                                    <span>Edytuj</span>
                                </a>

                                <button 
                                    v-if="post.user_id === user.id" 
                                    @click="confirmDelete(post.id)" 
                                    class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded flex items-center space-x-1"
                                >
                                    <i class="fas fa-trash"></i>
                                    <span>Usuń</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-center space-x-4">
                    <button 
                        v-if="pagination.current_page > 1" 
                        @click="goToPage(pagination.current_page - 1)"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded"
                    >
                        Poprzednia
                    </button>
                    
                    <span class="text-gray-700 dark:text-gray-300 font-semibold">
                        Strona {{ pagination.current_page }} z {{ pagination.last_page }}
                    </span>
                    
                    <button 
                        v-if="pagination.current_page < pagination.last_page" 
                        @click="goToPage(pagination.current_page + 1)"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded"
                    >
                        Następna
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import axios from 'axios'; 

const page = usePage();
const user = page.props.auth.user;
const posts = ref({ data: [], current_page: 1, last_page: 1 });
const pagination = ref({ current_page: 1, last_page: 1 });

const fetchPosts = async (pageNumber = 1) => {
    try {
        const response = await axios.get(`/posts?page=${pageNumber}`);
        posts.value = response.data.data;
        pagination.value = {
            current_page: response.data.meta.current_page,
            last_page: response.data.meta.last_page,
        };
    } catch (error) {
        console.error(error);
    }
};

const confirmDelete = async (postId) => {
    const confirmed = confirm("Czy na pewno chcesz usunąć ten post?");
    if (confirmed) {
        try {
            await axios.delete(`/post/${postId}/delete`);
            fetchPosts(pagination.value.current_page); 
        } catch (error) {
            console.error("Błąd podczas usuwania posta:", error);
        }
    }
};

const goToPage = (page) => {
    fetchPosts(page);
};

onMounted(() => {
    fetchPosts(); 
});
</script>
