<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold tex-x1 text-gray-800 
              leading-tight">
        Nueva cliente
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7x1 mx-auto sm:px-6 lg:px-8">
        <jet-form-section @submitted="guardarcliente">
          <template #title>Información sobre el cliente</template>
          <template #descripcion>
            <p class="text-lg text-gray-600">Agregar Nuevo cliente</p>
          </template>
          <template #form>
            <!-- cliente nombre -->
            <div class="col-span-6 sm:col-span-4">
              <jet-label for="nombre" value="Nombre" class="text-lg font-semibold" />
              <jet-input id="nombre" type="text"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                v-model="form.nombre" autocomplete="nombre" />
              <jet-input-error :message="form.errors.nombre" class="mt-2 text-red-500" />
            </div>
            <!-- info contcto -->
            <div class="col-span-6 sm:col-span-4">
              <jet-label for="direccion" value="Direccion" class="text-lg font-semibold" />
              <jet-input id="direccion" type="text"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                v-model="form.direccion" autocomplete="direccion" />
              <jet-input-error :message="form.errors.direccion" class="mt-2 text-red-500" />
            </div>

            <div class="col-span-6 sm:col-span-4">
              <jet-label for="telefono" value="Telefono" class="text-lg font-semibold" />
              <jet-input id="telefono" type="text"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                v-model="form.telefono" autocomplete="telefono" />
              <jet-input-error :message="form.errors.telefono" class="mt-2 text-red-500" />
            </div>

            <div class="col-span-6 sm:col-span-4">
              <jet-label for="email" value="Email" class="text-lg font-semibold" />
              <jet-input id="email" type="text"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                v-model="form.email" autocomplete="email" />
              <jet-input-error :message="form.errors.email" class="mt-2 text-red-500" />
            </div>

          </template>

          <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3 text-green-500">
              Registro Guardado
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
              class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
              Guardar
            </jet-button>

            <jet-button @click="cancelar" class="ml-3 border-gray-300 border rounded text-gray-600 hover:text-gray-800">
              Cancelar
            </jet-button>
          </template>

        </jet-form-section>
      </div>

    </div>

  </app-layout>
</template>
  
<script>
import { useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import { normalizeClass } from "vue";

export default {
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
  },

  props: {
    errors: Object,
  },

  mounted() {
    console.log(this.clientes);
  },
  
  setup(props) {
    //useForm hace referencia a la clase @inertijs/inertia-vue3
    const form = useForm({
      _method: "POST",
      id: null,
      nombre: null,
      direccion: null,
      telefono: null,
      email: null,

    });

    //inertia cambio de form.value.post. en el actual ya se usa
    //solamente form.post

    const guardarcliente = () => {
      form.post(route("clientes.store"), form);
    };
    const cancelar = () => {
      // Limpia los campos del formulario o realiza cualquier otra acción de cancelar
      form.reset(); // Esto reinicia los valores del formulario
      
      // Redirige a la página deseada (por ejemplo, la página de lista de clientes)
      window.location.href = "/clientes";
    };
    return { form, guardarcliente, cancelar };
    
  },
};
</script>