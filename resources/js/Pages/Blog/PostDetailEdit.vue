<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps({
    post: Object,
});

const form = useForm({
    title: props.post.title,
    excerpt: props.post.excerpt,
    content: props.post.content,
});

const submit = async () => {
    try {
        await axios.put(`/post/edit/${props.post.id}`, form.data());
        form.reset();
        alert('Poprawnie edytowano post')
        window.location = '/blog'
    } catch (error) {
        console.error(error);
    }
};
</script>

<template>
    <Head title="Edycja Postu" />
    
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Edytuj Post
            </h2>
        </template>

        <div class="py-12">
            <div class="bg-slate-800 mx-auto max-w-7xl sm:px-6 lg:px-8 py-4">
                <form @submit.prevent="submit">
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-300">Tytuł</label>
                        <input
                            id="title"
                            v-model="form.title"
                            type="text"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                        />
                        <span v-if="form.errors.title" class="text-red-500 text-sm">{{ form.errors.title }}</span>
                    </div>

                    <div class="mb-6">
                        <label for="excerpt" class="block text-sm font-medium text-gray-300">Wstęp</label>
                        <textarea
                            id="excerpt"
                            v-model="form.excerpt"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                        ></textarea>
                        <span v-if="form.errors.excerpt" class="text-red-500 text-sm">{{ form.errors.excerpt }}</span>
                    </div>

                    <div class="mb-6">
                        <label for="content" class="block text-sm font-medium text-gray-300">Treść</label>
                        <textarea
                            id="content"
                            v-model="form.content"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                        ></textarea>
                        <span v-if="form.errors.content" class="text-red-500 text-sm">{{ form.errors.content }}</span>
                    </div>

                    <div class="mt-6">
                        <button
                            type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded"
                        >
                            Zapisz zmiany
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
