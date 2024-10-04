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
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-slate-800 shadow-lg rounded-lg overflow-hidden p-6">
                    <div class="flex flex-col">
                        <form @submit.prevent="addPost">
                            <div>
                                <label>Tytuł: </label>
                                <input type="text" v-model="form.title" placeholder="Tytuł posta"/>
                            </div>
                            
                            <div>
                                <label>Krótki opis: </label>
                                <input type="text" v-model="form.excerpt" placeholder="Krótki opis"/>
                            </div>
                            
                            <div>
                                <label>Zawartość: </label>
                                <input type="text" v-model="form.content" placeholder="Zawartość posta"/>
                            </div>
                            <div>
                                <input type="submit" value="Dodaj" />
                            </div>
                        </form>
                    </div>
                </div>   
            </div>
        </div>
    </AuthenticatedLayout>
</template>
