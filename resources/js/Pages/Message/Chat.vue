<template>
    <AppLayout title="Listado de Publicaciones">
        <!-- Encabezado -->
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Listado de Publicaciones
            </h2>
        </template>
        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <main class="container mx-auto mt-8">
                        <div class="flex flex-wrap justify-center">
                            <div>

                                <h1 class="font-semibold text-xl text-gray-800 leading-tight"> {{ users.name }}</h1>

                                <!-- Mostrar los mensajes anteriores -->
                                <div v-for="message in messages" :key="message.id">
                                    <p>{{ message.content }}</p>
                                </div>

                                <!-- Formulario para enviar un nuevo mensaje -->
                                <form @submit.prevent="sendMessage">
                                    <input
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        v-model="newMessage" type="text" placeholder="Escribe un mensaje" />
                                    <button class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded"
                                        type="submit">Enviar</button>
                                </form>
                            </div>

                        </div>
                    </main>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
  
<script>
//importaci9nes
import AppLayout from "@/Layouts/AppLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import { Link } from '@inertiajs/inertia-vue3'
import Welcome from "@/Jetstream/Welcome.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";


export default {
    props: ["publicars", "users"],
  components: {
    AppLayout,
    Welcome,
    JetActionMessage,
    JetButton,
    JetFormSection,
    JetInput,
    JetInputError,
    JetLabel,
    JetSecondaryButton,

    Link
},
    data() {
        return {
            messages: [], // Almacena los mensajes recuperados de la base de datos
            newMessage: '', // Almacena el nuevo mensaje que el usuario está escribiendo
        };
    },
    props: {
        users: Object, // El usuario con el que se está chateando
    },
    methods: {
        sendMessage() {
            // Validar que el campo de mensaje no esté vacío
            if (!this.newMessage.trim()) {
                return;
            }

            // Enviar el nuevo mensaje al servidor (debes implementar esto)
            // Luego, agregar el mensaje a la lista de mensajes
            // Esto es solo un ejemplo, debes ajustarlo según tu implementación
            const message = {
                content: this.newMessage,
            };

            // Agregar el mensaje a la lista
            this.messages.push(message);

            // Limpia el campo de entrada
            this.newMessage = '';
        },
    },
};
</script>
  
<style scoped>/* Estilos CSS específicos para este componente */</style>
  