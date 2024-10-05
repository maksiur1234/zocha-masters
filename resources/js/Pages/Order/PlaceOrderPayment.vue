<script setup>
import { onMounted, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';

const shippingDetails = ref({});
const selectedDeliveryData = ref({});
const paymentForm = ref({
    payment_method: ""
});

const totalPrice = ref(0); 
const cartTotal = ref(0);

const getCartData = async () => {
    try {
        const response = await axios.get('/cart-data');
        const cartData = response.data; 

        cartTotal.value = Object.values(cartData).reduce((total, item) => {
            return total + (parseFloat(item.price) || 0); 
        }, 0);

        totalPrice.value = cartTotal.value; 
    } catch (error) {
        console.error("Błąd podczas pobierania danych koszyka:", error);
    }
};

onMounted(() => {
    getCartData(); 

    const savedDetails = localStorage.getItem('shippingDetails');
    if (savedDetails) {
        shippingDetails.value = JSON.parse(savedDetails);
    }
    const savedDeliveryMethod = localStorage.getItem('selectedDeliveryMethod');
    if (savedDeliveryMethod) {
        selectedDeliveryData.value = JSON.parse(savedDeliveryMethod);
    }
});

const getToken = async () => {
    try {
        await axios.get('/sanctum/csrf-cookie');
    } catch (error) {
        console.error("Failed in getting CSRF:", error);
    }
};

const savePaymentMethod = async () => {
    localStorage.setItem('paymentMethod', paymentForm.value.payment_method);
    
    try {
        await getToken(); 
         await axios.post('/checkout');
    } catch (error) {
        console.error("Error with sending payment:", error);
    }
};
</script>

<template>
    <Head title="Sklep" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Zakup produktów etap 3/3
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-slate-600 shadow rounded-lg p-6">
                    <h1 class="text-2xl font-bold mb-4">Podsumowanie zamówienia</h1>
                    
                    <h2 class="text-xl font-semibold">Adres dostawy:</h2>
                    <p>{{ shippingDetails.first_name }} {{ shippingDetails.last_name }}</p>
                    <p>{{ shippingDetails.street }}</p>
                    <p>{{ shippingDetails.city }}, {{ shippingDetails.postalCode }}</p>
                    
                    <h2 class="text-xl font-semibold mt-4">Metoda dostawy:</h2>
                    <p>{{ selectedDeliveryData.method }} - {{ (selectedDeliveryData.price || 0).toFixed(2) }} PLN</p>

                    <h2 class="text-xl font-semibold mt-4">Szczegóły płatności:</h2>
                    <p>Cena produktów: {{ totalPrice.toFixed(2) }} PLN</p>
                    <p>Łączny koszt zamówienia: {{ (totalPrice + (selectedDeliveryData.price || 0)).toFixed(2) }} PLN</p>

                    <h2 class="text-xl font-semibold mt-4">Wybierz metodę płatności:</h2>
                    <form @submit.prevent="savePaymentMethod" method="post">
                        <div class="mb-4">
                            <label for="payment_method" class="block mb-2">Metoda płatności:</label>
                            <select v-model="paymentForm.payment_method" id="payment_method" required class="border rounded p-2 w-full">
                                <option value="" disabled selected>Wybierz metodę płatności</option>
                                <option value="stripe">Stripe</option>
                            </select>
                        </div>

                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Zapłać</button>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
