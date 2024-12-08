<template>
    <app-layout>
      <template #header>
        <h2 class="font-semibold tex-x1 text-gray-800 leading-tight">
          Editar Producto
        </h2>
      </template>
      <div class="py-12">
        <div class="max-w-7x1 mx-auto sm:px-6 lg:px-8">
          <jet-form-section @submitted="actualizarProducto">
            <template #title>Información sobre el Producto</template>
            <template #descripcion>
              Actualizar información de Producto
            </template>
            <template #form>
            <!-- nombre_producto -->
            <div class="col-span-6 sm:col-span-4">
              <jet-label for="nombre_producto" value="Nombre del Producto" class="text-lg font-semibold" />
              <jet-input id="nombre_producto" type="text"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                v-model="form.nombre_producto" autocomplete="nombre_producto" />
              <jet-input-error :message="form.errors.nombre_producto" class="mt-2 text-red-500" />
            </div>

            <!-- descripcion -->
            <div class="col-span-6 sm:col-span-4">
              <jet-label for="descripcion" value="Descripción" class="text-lg font-semibold" />
              <jet-input id="descripcion" type="text"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                v-model="form.descripcion" autocomplete="descripcion" />
              <jet-input-error :message="form.errors.descripcion" class="mt-2 text-red-500" />
            </div>

            <!-- precio_compra -->
            <div class="col-span-6 sm:col-span-4">
              <jet-label for="precio_compra" value="Precio de Compra" class="text-lg font-semibold" />
              <jet-input id="precio_compra" type="number" step="0.01"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                v-model="form.precio_compra" autocomplete="precio_compra" />
              <jet-input-error :message="form.errors.precio_compra" class="mt-2 text-red-500" />
            </div>

            <!-- precio_venta -->
            <div class="col-span-6 sm:col-span-4">
              <jet-label for="precio_venta" value="Precio de Venta" class="text-lg font-semibold" />
              <jet-input id="precio_venta" type="number" step="0.01"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                v-model="form.precio_venta" autocomplete="precio_venta" />
              <jet-input-error :message="form.errors.precio_venta" class="mt-2 text-red-500" />
            </div>

            <!-- id_proveedor -->
            <div class="col-span-6 sm:col-span-4">
              <jet-label for="id_proveedor" value="Proveedor" class="text-lg font-semibold" />
              <select id="id_proveedor"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                v-model="form.id_proveedor">
                <option value="">Seleccionar Proveedor</option>
                <option v-for="proveedor in proveedores" :key="proveedor.id" :value="proveedor.id">
                  {{ proveedor.nombre_proveedor }}
                </option>
              </select>
            </div>

            <!-- id_categoria -->
            <div class="col-span-6 sm:col-span-4">
              <jet-label for="id_categoria" value="Categoria" class="text-lg font-semibold" />
              <select id="id_categoria"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                v-model="form.id_categoria">
                <option value="">Seleccionar Categoria</option>
                <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">
                  {{ categoria.nombre_categoria }}
                </option>
              </select>
            </div>

          </template>
            <template #actions>
              <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Registro Actualizado
              </jet-action-message>
              <jet-secondary-button @click="volver" class="mr-2 mb-2">
                Volver
              </jet-secondary-button>
              <jet-button
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded"
              >
                Actualizar
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
  import JetButton from "@/Jetstream/Button.vue";
  import JetFormSection from "@/Jetstream/FormSection.vue";
  import JetInput from "@/Jetstream/Input.vue";
  import JetInputError from "@/Jetstream/InputError.vue";
  import JetLabel from "@/Jetstream/Label.vue";
  import JetActionMessage from "@/Jetstream/ActionMessage.vue";
  import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
  
  export default {
    components: {
      AppLayout,
      JetActionMessage,
      JetButton,
      JetFormSection,
      JetInput,
      JetInputError,
      JetLabel,
      JetSecondaryButton,
    },
  
    props: {
      productos: Object,
      proveedores: Array,
    categorias: Array,
    },
    mounted() {
        console.log(this.productos);
    },
  
    setup(props) {
      const form = useForm({
        _method: "PUT",
        id: props.productos.id,
        nombre_producto: props.productos.nombre_producto,
        descripcion: props.productos.descripcion,
        precio_compra: props.productos.precio_compra,
        precio_venta: props.productos.precio_venta,
        id_proveedor: props.productos.id_proveedor,
        id_categoria: props.productos.id_categoria,
      });
  
      const actualizarProducto = () => {
            form.post(route("productos.update", props.productos.id), {
                preserveScroll: true,
            });
        };
  
      return { form, actualizarProducto};
    },
  };
  </script>
  