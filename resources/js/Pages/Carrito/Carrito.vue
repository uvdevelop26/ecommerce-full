<template>
  <AppLayout title="Listado">
    <!-- Encabezado -->
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Carritos
        <Link :href="route('inicio.index')" class="float-right">
        <jet-button>Nuevo</jet-button>
        </Link>
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
                          id de carrito
                        </th>
                        <th scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          user_id
                        </th>
                        <th scope="col"
                          class="text-center px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Acciones
                        </th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      <template v-if="carrito">
                        <tr>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ carrito.id }}</td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ carrito.user_id }}</td>
                          <td class="px-14 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <Link :href="route('itemcarritos.index', carrito.id)"
                              class="ml-2 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Editar
                            </Link>
                            <Link @click="eliminarcarrito(carrito)"
                              class="ml-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Eliminar
                            </Link>
                          </td>
                        </tr>
                      </template>
                      <template v-else>
                        <tr>
                          <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                            El usuario no tiene carrito
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
import { Link } from '@inertiajs/inertia-vue3'

export default {
  props: ["carritos"],

  components: {
    AppLayout,
    Welcome,
    JetButton,
    JetInput,
    Link
  },
  setup(props) {
    console.log('Carrito recibido:', props.carritos);

    const carrito = props.carritos && props.carritos.length > 0 ? props.carritos[0] : null;

    const eliminarcarrito = (data) => {
      data._method = "DELETE";
      Inertia.post("/carritos/" + data.id, data);
    };

    return { carrito, eliminarcarrito };
  },


};

</script>