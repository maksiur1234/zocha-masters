<script setup>
import { defineProps } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    product: {
        type: Object,
        required: true
    }
});

</script>

<template>
    <Head title="Szczegóły Produktu" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Szczegóły produktu - {{ product.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-slate-800 shadow-lg rounded-lg overflow-hidden">
                    <img :src="product.image" alt="Produkt" class="w-full h-64 object-cover">
                    <div class="p-6 text-center text-slate-200">
                        <h3 class="text-lg font-bold text-white-900">{{ product.name }}</h3>
                        <p class="mt-4 text-white-200">{{ product.description }}</p>
                        <div class="flex justify-center items-center mt-4">
                            <p class="text-xl font-semibold text-black-900">{{ product.price }} PLN</p>
                            
                        </div>
                        <div class="flex justify-center items-center mt-4">
                            <p class="text-gray-600 ml-4">Dostępność: {{ product.stock }}</p>
                        </div>
                        <button class="mt-6 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                            Dodaj do koszyka
                        </button>
                    </div>
                </div>

                <div class="mt-8 bg-slate-800 p-4 rounded-lg text-center">
                    <h3 class="text-xl text-slate-200 font-semibold mb-4">Specyfikacje Produktu</h3>
                    <ul class="list-disc text-slate-300 pl-5 inline-block">
                        <li><strong>Kategoria:</strong> {{ product.category }}</li>
                        <li><strong>Waga:</strong> {{ product.weight }} g</li>
                        <li><strong>Rozmiar:</strong> {{ product.size }}</li>
                        <li><strong>Materiał:</strong> {{ product.material }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
