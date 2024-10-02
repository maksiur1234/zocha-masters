<script setup>
import { defineProps } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    post: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <Head title="Szczegóły posta" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Szczegóły posta - {{ post.title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-slate-800 shadow-lg rounded-lg overflow-hidden p-6">
                    
                    <h3 class="text-xl font-bold text-slate-200 mb-4">
                        {{ post.title }}
                    </h3>
                    
                    <p class="text-slate-300 mb-4">
                        {{ post.excerpt }}
                    </p>
                    
                    <div class="prose prose-invert text-slate-200">
                        <p v-html="post.content"></p>
                    </div>

                </div>   
            </div>
        </div>
    </AuthenticatedLayout>
</template>
