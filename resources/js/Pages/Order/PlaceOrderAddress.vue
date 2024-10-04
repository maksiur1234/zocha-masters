<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const form = ref({
    first_name: "",
    last_name: "",
    address_line_1: "",
    address_line_2: "",
    city: "",
    postal_code: "",
    country: "",
    phone: ""
});

const message = ref(null);

const saveShippingDetails = () => {
    localStorage.setItem('shippingDetails', JSON.stringify(form.value));
    window.location.href = "/place-order-delivery";
};
</script>

<template>
    <Head title="Sklep" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Zakup produktów etap 1/3
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-slate-600 shadow-md rounded-lg p-8">
                    <h2 class="text-2xl font-bold mb-6 text-white-800">Krok 1: Wprowadź adres dostawy</h2>
                    <form @submit.prevent="saveShippingDetails" class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-white-700">Imię:</label>
                            <input v-model="form.first_name" id="first_name" type="text" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500 p-2" />
                        </div>

                        <div>
                            <label for="last_name" class="block text-sm font-medium text-white-700">Nazwisko:</label>
                            <input v-model="form.last_name" id="last_name" type="text" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500 p-2" />
                        </div>

                        <div>
                            <label for="address_line_1" class="block text-sm font-medium text-white-700">Adres (Linia 1):</label>
                            <input v-model="form.address_line_1" id="address_line_1" type="text" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500 p-2" />
                        </div>

                        <div>
                            <label for="address_line_2" class="block text-sm font-medium text-white-700">Adres (Linia 2, opcjonalnie):</label>
                            <input v-model="form.address_line_2" id="address_line_2" type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500 p-2" />
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-medium text-white-700">Miasto:</label>
                            <input v-model="form.city" id="city" type="text" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500 p-2" />
                        </div>

                        <div>
                            <label for="postal_code" class="block text-sm font-medium text-white-700">Kod pocztowy:</label>
                            <input v-model="form.postal_code" id="postal_code" type="text" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500 p-2" />
                        </div>

                        <div>
                            <label for="country" class="block text-sm font-medium text-white-700">Kraj:</label>
                            <input v-model="form.country" id="country" type="text" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500 p-2" />
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-white-700">Telefon:</label>
                            <input v-model="form.phone" id="phone" type="tel" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500 p-2" />
                        </div>

                        <button type="submit" class="mt-4 bg-blue-600 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">Dalej</button>
                    </form>

                    <div v-if="message" class="mt-4 text-red-600">
                        <p>{{ message }}</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.shipping-form {
    max-width: 400px;
    margin: auto;
}
</style>
