<script setup>
import { onMounted, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';

const products = ref([]);

const fetchProducts = async () => {
    try {
        const response = await axios.get('/products');
        products.value = response.data;
        console.log(products.value);
    } catch (error) {
        console.error(error);
    }
}

const addToCart = async (product) => {
    try {
        const response = await axios.post('/cart/add', {
            product_id: product.id,
            name: product.name,
            price: product.price,
            image: product.image,
        });

        alert('Produkt dodany do koszyka!')
    } catch (error) {
        console.error(error);
        console.error('Wystąpił błąd przy dodawaniu do koszyka.');
    }
}

onMounted(() => {
    fetchProducts();
})
</script>

<template>
    <Head title="Sklep" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Sklep
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
        </div>
    </AuthenticatedLayout>
</template>
