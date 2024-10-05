<script setup>
import { onMounted, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';

const products = ref([]);
const pagination = ref({});

const fetchProducts = async (page = 1) => {
    try {
        const response = await axios.get(`/products?page=${page}`);
        products.value = response.data.data;
        pagination.value = response.data.meta;
    } catch (error) {
        console.error(error);
    }
};

const goToPage = (page) => {
    fetchProducts(page);
};

onMounted(() => {
    fetchProducts();
});
</script>

<template>
    <Head title="Sklep" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Sklep - Zocha masters
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <div
                    v-for="product in products"
                    :key="product.id"
                    class="bg-slate-800 shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105"
                >
                    <img :src="product.image" alt="Zośka" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ product.name }}</h3>
                        <p class="text-gray-700 dark:text-gray-400 mt-1">{{ product.description }}</p>
                        <p class="text-xl font-semibold text-gray-900 dark:text-gray-100 mt-4">{{ product.price }} PLN</p>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Dostępność: {{ product.stock }}</p>
                        <div class="flex gap-6">
                            <a :href="`/product/${product.id}`" class="mt-4 w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded text-center">
                                Zobacz szczegóły
                            </a>
                            <button 
                                @click="addToCart(product)"
                                class="mt-4 w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded">
                                Dodaj do koszyka
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
                    :disabled="pagination.current_page === 1">
                    Poprzednia
                </button>
                
                <span class="text-gray-700 dark:text-gray-300 font-semibold">
                    Strona {{ pagination.current_page }} z {{ pagination.last_page }}
                </span>
                
                <button 
                    v-if="pagination.current_page < pagination.last_page" 
                    @click="goToPage(pagination.current_page + 1)"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded"
                    :disabled="pagination.current_page === pagination.last_page">
                    Następna
                </button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
