<template>
  <AppLayout title="Listado de Productos">
    <!-- Encabezado -->
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Listado de Productos
        <Link :href="route('ventas.create')" class="float-right">
        <jet-button>Nuevo</jet-button>
        </Link>
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <!-- Buscador-->
          <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                  <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        <th scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Código
                        </th>
                        <th scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Producto
                        </th>
                        <th scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Cliente
                        </th>
                        <th scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Cantidad
                        </th>
                        <th scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                         subtotal
                        </th>
    
                        <th scope="col"
                          class="text-center px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Acciones
                        </th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      <template v-if="ventas.length === 0">
                        <tr>
                          <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                            NO HAY DATOS DE PRODUCTOS PARA MOSTRAR
                          </td>
                        </tr>
                      </template>
                      <template v-else>
                        <tr v-for="venta in ventas" :key="venta.id">
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ venta.id }}
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ venta.nombre_producto }}
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ venta.nombre }}
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ venta.cantidad }}
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ venta.subtotal }}
                          </td>
                          <td class="px-14 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <Link :href="route('ventas.edit', venta.id)"
                              class="ml-2 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Editar
                            </Link>
                            <Link @click="eliminarVentas(venta)"
                              class="ml-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Eliminar
                            </Link>
                          </td>
                        </tr>
                      </template>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
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
  props: ["ventas"],
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
        ventas: Array,
    },

  setup(props) {
    const eliminarVentas = (data) => {
      data._method = "DELETE";
      Inertia.post("/ventas/" + data.id, data);
    };

    return { eliminarVentas };
  },
};
</script>
