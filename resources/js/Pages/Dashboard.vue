

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
            <div class="py-4">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <main class="container mx-auto mt-8">
            <div class="flex flex-wrap justify-center">
              <!-- Loop through product publications -->
              <div v-for="publicar in publicars" :key="publicar.id"
                class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/4 px-4 mb-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden ">

                  <div class="p-4">
                    <img :src="'/images/' + publicar.imagen" alt="Imagen del producto"
                      class="h-40 object-cover rounded-t-lg" />

                    <h2 class="text-xl font-semibold text-gray-800">{{ publicar.nombre_producto }}</h2>
                    <p class="text-sm text-gray-600 mt-2">Cantidad: {{ publicar.cantidad }}</p>
                    <p class="text-sm text-gray-600 mt-2">Precio: {{ publicar.precio }}/{{ publicar.detalles }}</p>
                    <p class="text-sm text-gray-600 mt-2">Vendedor: {{ publicar.name }}</p>
                    <div class="mt-4">
                      <a v-if="users && publicar && users.id !== publicar.user_id"
                        :href="route('message.show', { message: publicar.user_id })"
                        class="bg-green-500 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-full block text-center">
                        Comprar
                      </a>
                      <a v-if="users && publicar && users.id === publicar.user_id"
                        :href="route('publicar.index', publicar.id)"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-full block text-center">
                        Ver detalles
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End of product publication loop -->
            </div>
          </main>
        </div>
      </div>
    </div>
        </template>
        

        
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

  props: {
    publicars: Object,
    users: Object,
  },

  setup(props) {
    const eliminarPublicar = (data) => {
      data._method = "DELETE";
      Inertia.post("/publicars/" + data.id, data);
    };

    return { eliminarPublicar };
  },
};
</script>
