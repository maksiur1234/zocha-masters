<template>
    <Head title="Twój koszyk" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-3xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Twój koszyk
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-slate-700 shadow-lg rounded-lg p-6">
                    <div class="grid grid-cols-1 gap-4">
                        <div v-for="(item, productId) in props.cart" :key="productId" class="flex items-center border-b border-gray-300 pb-4">
                            <img :src="item.image" alt="Product Image" class="w-24 h-24 object-cover rounded-md mr-4" />
                            <div class="flex-1 p-6 m-4">
                                <h3 class="text-lg font-semibold text-slate-100">{{ item.name }}</h3>
                                <p class="text-slate-100">Cena: <span class="font-bold">{{ item.price }} PLN</span></p>
                                <p class="text-slate-100">Ilość: <span class="font-bold">{{ item.quantity }}</span></p>
                            </div>
                            <div>
                                <button @click="removeFromCart(productId)" class="text-red-600 hover:text-red-800">
                                    Usuń
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 border-t border-gray-300 pt-4">
                        <div class="flex justify-between">
                            <h4 class="text-xl text-slate-200 font-semibold">Całkowity koszt:</h4>
                            <p class="text-xl text-slate-200 font-bold">{{ totalPrice }} PLN</p>
                        </div>
                        <div class="mt-4">
                            <a href="/place-order-address" class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                                Przejdź do płatności
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { computed, defineProps, toRefs } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps({
    cart: {
        type: Object,
        required: true
    }
});

const { cart } = toRefs(props);

const totalPrice = computed(() => {
    return Object.values(props.cart).reduce((total, item) => {
        return total + (item.price * item.quantity);
    }, 0);
});

const removeFromCart = async (productId) => {
    try {
        await axios.delete(`/cart/remove/${productId}`);

        delete cart.value[productId];
    } catch (error) {
        console.error(error)
    }
};

const proceedToCheckout = () => {
    console.log('do koszyka')
};
</script>
