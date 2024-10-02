<script setup>
import { onMounted, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';

const products = ref([]);

const fetchProducts = async () => {
    try {
        const response = await axios.get('/promoted-products');
        products.value = response.data;
        console.log(products.value);
    } catch (error) {
        console.error(error);
    }
}

onMounted(() => {
    fetchProducts();
})
</script>

<template>
    <Head title="Zocha Masters" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Strona główna - Zocha Masters
            </h2>
        </template>

        <div class="py-12">
            <div class="bg-slate-800 mx-auto max-w-7xl sm:px-6 lg:px-8 py-4">
                <div class="bg-blue-500 text-white text-center p-4 rounded-lg mb-6">
                    <h3 class="text-lg font-semibold">Zniżka 20% na pierwsze zakupy!</h3>
                    <p>Wprowadź kod: ZOCHA420 przy składaniu zamówienia.</p>
                </div>

                <h3 class="text-2xl text-slate-200 font-bold mb-4">Nasze Bestsellery</h3>
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <div
                        v-for="product in products"
                        :key="product.id"
                        class="bg-slate-800 shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105 border border-gray-700"
                    >
                        <img :src="product.image" alt="Zośka" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ product.name }}</h3>
                            <p class="text-gray-700 dark:text-gray-400 mt-1">{{ product.description }}</p>
                            <div class="flex gap-6">
                                <button class="mt-4 w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded">
                                    Zobacz szczegóły
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-slate-800 rounded-lg p-6 mt-8 shadow-md">
                    <h3 class="text-2xl text-slate-200 font-semibold mb-4">O Zocha Masters</h3>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">
                        Zocha Masters to marka, która łączy pasję do footbagów z jakością i stylem. Nasze produkty są stworzone z myślą o wszystkich miłośnikach sportów ulicznych. Niezależnie od tego, czy jesteś profesjonalistą, czy dopiero zaczynasz swoją przygodę z footbagiem, mamy coś dla Ciebie!
                    </p>
                    <p class="text-gray-500 dark:text-gray-400">
                        Sprawdź nasze najnowsze kolekcje i dołącz do społeczności Zocha Masters!
                    </p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
