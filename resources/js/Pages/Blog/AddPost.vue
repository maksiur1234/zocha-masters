<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';

const form = ref({
    title: "",
    excerpt: "",
    content: "",
});

const getToken = async () => {
    await axios.get('/sanctum/csrf-cookie');
}

const addPost = async () => {
    try {
        await getToken();
        await axios.post('/store-post', form.value);

        form.value = {
            title: "",
            excerpt: "",
            content: "",
        };
        
        alert('Poprawnie dodano post')
        window.location = '/blog'
    } catch (error) {
        console.error("Błąd podczas dodawania posta:", error);
    }
};
</script>

<template>
    <Head title="Dodaj post" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Dodaj post 
            </h2>
        </template>

        <div class="py-12">
            <div class="bg-slate-800 mx-auto max-w-7xl sm:px-6 lg:px-8 py-4 shadow-lg rounded-lg">
                <form @submit.prevent="addPost" class="p-6">
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-300">Tytuł</label>
                        <input
                            id="title"
                            type="text"
                            v-model="form.title"
                            placeholder="Tytuł posta"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                        />
                    </div>
                    
                    <div class="mb-6">
                        <label for="excerpt" class="block text-sm font-medium text-gray-300">Krótki opis</label>
                        <input
                            id="excerpt"
                            type="text"
                            v-model="form.excerpt"
                            placeholder="Krótki opis"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                        />
                    </div>
                    
                    <div class="mb-6">
                        <label for="content" class="block text-sm font-medium text-gray-300">Zawartość</label>
                        <textarea
                            id="content"
                            v-model="form.content"
                            placeholder="Zawartość posta"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                        ></textarea>
                    </div>
                    
                    <div class="mt-6">
                        <button
                            type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded"
                        >
                            Dodaj
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
