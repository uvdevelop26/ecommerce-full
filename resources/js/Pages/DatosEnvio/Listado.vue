<template>
  <AppLayout title="Listado">
    <!-- Encabezado -->
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Listado de Categorias

      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <!-- This example requires Tailwind CSS v2.0+ -->
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
                          ciudad
                        </th>
                        <th scope="col"
                          class="text-center px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          departamento
                        </th>
                        <th scope="col"
                          class="text-center px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          telefono
                        </th>
                        <th scope="col"
                          class="text-center px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          carrito_id

                        </th>

                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      <template v-if="datosenvio.length === 0">
                        <tr>
                          <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                            NO HAY DATOS DE PRODUCTOS PARA MOSTRAR
                          </td>
                        </tr>
                      </template>
                      <template v-else>
                        <tr v-for="datosenvio in datosenvio" :key="datosenvio.id">
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ datosenvio.id }}
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ datosenvio.ciudad_id }}
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ datosenvio.departamento_id }}
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ datosenvio.telefono }}
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ datosenvio.carrito_id }}
                          </td>


                          <td class="px-14 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <Link :href="route('datosenvio.edit', datosenvio.id)"
                              class="ml-2 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Editar
                            </Link>
                            <Link @click="eliminardatosenvio(datosenvio)"
                              class="ml-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Eliminar
                            </Link>
                            <Link 
                              class="ml-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            En espera
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
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import JetButton from "@/Jetstream/Button.vue";
import { Inertia } from "@inertiajs/inertia";
import JetInput from "@/Jetstream/Input.vue";
import { reactive, watchEffect, ref } from "vue";
import { pickBy } from "lodash";
import { Link } from '@inertiajs/inertia-vue3'

export default {

  components: {
    AppLayout,
    Welcome,
    JetButton,
    JetInput,
    Link
  },

  props: {
    datosenvio: Array,
  },
  mounted() {
    console.log('datosenvio:', this.datosenvio);

    // Llamamos a la función para cambiar las cartas automáticamente cada 10 segundos
  },
  setup(props) {
    const eliminardatosenvio = (data) => {
      data._method = "DELETE";
      Inertia.post("/datosenvio/" + data.id, data);

    };

    return { eliminardatosenvio };
  },
};

</script>