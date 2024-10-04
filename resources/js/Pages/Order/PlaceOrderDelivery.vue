<script setup>
import { onMounted, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';

const shippingDetails = ref({});
const selectedDeliveryMethod = ref('');
const deliveryMethods = ref([
    { id: 'Kurier', name: 'Dostawa kurierem', price: 20 },
    { id: 'Paczkomat', name: 'Dostawa do paczkomatu', price: 15 },
    { id: 'Odbiór osobisty', name: 'Odbiór osobisty', price: 0 },
]);
const useSameAddress = ref(true);
const newAddress = ref({});

onMounted(() => {
    const savedDetails = localStorage.getItem('shippingDetails');
    if (savedDetails) {
        shippingDetails.value = JSON.parse(savedDetails);
    }
});

const saveDeliveryMethod = () => {
    const deliveryData = {
        method: selectedDeliveryMethod.value,
        price: deliveryMethods.value.find(method => method.id === selectedDeliveryMethod.value)?.price || 0,
        address: useSameAddress.value ? shippingDetails.value : newAddress.value,
    };

    localStorage.setItem('selectedDeliveryMethod', JSON.stringify(deliveryData));
    
    window.location.href = "/place-order-payment"; 
};
</script>

<template>
    <Head title="Sklep" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Zakup produktów etap 2/3
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <div class="text-slate-200">
                    <h2>Wybierz rodzaj dostawy</h2>
                    <div class="mt-4">
                        <label class="block mb-2 text-lg font-semibold">Metody dostawy:</label>
                        <div v-for="method in deliveryMethods" :key="method.id" class="flex items-center mb-4">
                            <input 
                                type="radio" 
                                :id="method.id" 
                                :value="method.id" 
                                v-model="selectedDeliveryMethod" 
                                class="mr-2"
                                required
                                @change="useSameAddress.value = method.id !== 'courier'" 
                            />
                            <label :for="method.id" class="text-lg">
                                {{ method.name }} - {{ method.price }} PLN
                            </label>
                        </div>
                    </div>

                    <div v-if="selectedDeliveryMethod === 'courier'" class="mt-4">
                        <label class="block mb-2">
                            <input 
                                type="checkbox" 
                                v-model="useSameAddress" 
                                class="mr-2" 
                            />
                            Użyj tego samego adresu
                        </label>

                        <div v-if="!useSameAddress">
                            <h3 class="text-lg font-semibold">Podaj nowy adres dostawy:</h3>
                            <label class="block mt-2">Ulica:</label>
                            <input type="text" v-model="newAddress.street" class="w-full mb-2" placeholder="Ulica" required />
                            <label class="block mt-2">Miasto:</label>
                            <input type="text" v-model="newAddress.city" class="w-full mb-2" placeholder="Miasto" required />
                            <label class="block mt-2">Kod pocztowy:</label>
                            <input type="text" v-model="newAddress.postalCode" class="w-full mb-2" placeholder="Kod pocztowy" required />
                        </div>
                    </div>
                    
                    <button @click="saveDeliveryMethod" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Dalej
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
