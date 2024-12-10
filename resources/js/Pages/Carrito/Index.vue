<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Edit from "../../Components/icons/Edit.vue";
import Delete from "../../Components/icons/Delete.vue";
import Modal from "../../Components/Modal.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetButton from "@/Jetstream/Button.vue";
import QuestionAlert from "../../Components/QuestionAlert.vue";
import RoundedLink from "../../Components/RoundedLink.vue";
import { Inertia } from "@inertiajs/inertia";
import JetInput from "@/Jetstream/Input.vue";
import { reactive, watchEffect, ref } from "vue";
import { pickBy } from "lodash";
import { Link, useForm } from "@inertiajs/inertia-vue3";

const modalIndex = ref(null);
const stockMax = ref(1);
const questionAlert = ref(null);

const props = defineProps({
    carrito: Array,
});

const integerToDecimal = (number) => {
    return new Intl.NumberFormat("es-ES", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    }).format(number);
};

const eliminaritem = (data) => {
    data._method = "DELETE";
    Inertia.post("/itemcarritos/" + data.id, data);

    questionAlert.value = null;
};

const closeModal = () => {
    modalIndex.value = null;
};

const handleCantidad = (index) => {
    const precioVenta =
        props.carrito.items[index].producto.publicars[0].precio_venta;

    form.subtotal = form.cantidad * precioVenta;
};

const form = useForm({
    _method: "PUT",
    id: "",
    cantidad: "",
    subtotal: "",
    carrito_id: props.carrito.id,
    producto_id: {},
});

const showOnModal = (index) => {
    const productoObject = props.carrito.items[index].producto;

    stockMax.value = productoObject.stock;
    form.id = props.carrito.items[index].id;
    form.cantidad = props.carrito.items[index].cantidad;
    form.subtotal = props.carrito.items[index].subtotal;
    form.producto_id = productoObject;

    modalIndex.value = index;
};

const editarItem = () => {
    form.post(route("itemcarritos.update", form.id), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            stockMax.value = 1;
            closeModal();
        },
    });
};
</script>

<template>
    <AppLayout title="Listado del Carrito">
        <!--  Encabezado -->
        <template #header>
            <h2
                class="text-md font-bold text-primary leading-tight flex items-center flex-wrap justify-between">
                Productos en tu Carrito
                  <RoundedLink
                    :href="route('ventas.create')"
                    class="shadow bg-gray-100 font-bold text-primary hover:bg-gray-200">
                    Continuar
                </RoundedLink> 
            </h2>
        </template>
        <section class="py-12">
            <div class="max-w-7xl mx-auto overflow-x-auto">
                <table
                    class="w-full text-sm whitespace-nowrap border-separate border-spacing-y-2 rounded-md">
                    <thead>
                        <tr class="text-left text-white underline">
                            <th
                                class="pb-4 pt-4 px-6 rounded-l-lg bg-secondary">
                                N°
                            </th>
                            <th class="pb-4 pt-4 px-6 bg-secondary">Código</th>
                            <th class="pb-4 pt-4 px-6 bg-secondary">
                                Producto
                            </th>
                            <th class="pb-4 pt-4 px-6 bg-secondary">
                                Precio Unitario
                            </th>
                            <th class="pb-4 pt-4 px-6 bg-secondary">
                                Cantidad
                            </th>
                            <th class="pb-4 pt-4 px-6 bg-secondary">
                                Subtotal
                            </th>
                            <th class="pb-4 pt-4 px-6 bg-secondary">Usuario</th>

                            <th
                                class="pb-4 pt-4 px-6 rounded-r-lg bg-secondary">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="carrito && carrito.items.length === 0">
                            <tr>
                                <td
                                    colspan="6"
                                    class="px-6 py-4 text-center text-sm text-gray-500">
                                    Aún no has Agregado Productos al Carrito
                                </td>
                            </tr>
                        </template>
                        <template v-else>
                            <tr
                                class="focus-within:bg-gray-100 shadow-md group"
                                v-for="(item, index) in carrito.items"
                                :key="item.id">
                                <td
                                    class="rounded-l-lg bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ index + 1 }}
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ item.producto.id }}
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 max-w-xs overflow-hidden group-hover:bg-gray-100">
                                    {{ item.producto.nombre_producto }}
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 max-w-xs overflow-hidden group-hover:bg-gray-100">
                                    {{
                                        item.producto.publicars[0].precio_venta
                                    }}
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ item.cantidad }}
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ integerToDecimal(item.subtotal) }}gs.
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ carrito.user.name }}
                                </td>
                                <td
                                    class="rounded-r-lg bg-gray-50 px-6 py-4 flex items-center gap-4 group-hover:bg-gray-100">
                                    <button
                                        @click.prevent="showOnModal(index)"
                                        class="text-sm font-medium text-secondary flex items-center gap-1 hover:underline">
                                        Editar
                                        <Edit
                                            class="block w-auto h-3 fill-secondary"
                                        />
                                    </button>
                                    <button
                                        type="button"
                                        @click="questionAlert = index"
                                        class="text-sm font-medium text-red-500 flex items-center gap-1 hover:underline">
                                        Eliminar
                                        <Delete
                                            class="block w-auto h-3 fill-red-500"
                                        />
                                    </button>
                                    <!-- modal Form -->
                                    <Modal
                                        :show="modalIndex === index"
                                        maxWidth="md"
                                        @close="closeModal">
                                        <form
                                            @submit.prevent="editarItem"
                                            class="flex flex-col gap-4">
                                            <!-- producto -->
                                            <div class="flex flex-col gap-2">
                                                <jet-label
                                                    for="nombre_producto"
                                                    value="Nombre del Producto"
                                                    class="text-lg font-semibold"
                                                />
                                                <jet-input
                                                    id="nombre_producto"
                                                    type="text"
                                                    class="mt-1 block w-full border-gray-300 shadow-sm"
                                                    autocomplete="nombre_producto"
                                                    v-model="form.producto_id.nombre_producto"
                                                    disabled
                                                />
                                            </div>
                                            <!-- cantidad -->
                                            <div class="flex flex-col gap-2">
                                                <jet-label
                                                    for="cantidad"
                                                    value="Cantidad"
                                                    class="text-lg font-semibold"
                                                />
                                                <jet-input
                                                    id="cantidad"
                                                    type="number"
                                                    class="mt-1 block w-full border-gray-300 shadow-sm"
                                                    autocomplete="cantidad"
                                                    min="1"
                                                    :max="stockMax"
                                                    v-model="form.cantidad"
                                                    @input="handleCantidad(index)"
                                                />
                                                <div
                                                    class="pt-2 font-medium text-gray-600">
                                                    Cantidad disponible:
                                                    {{ item.producto.stock }}
                                                </div>
                                            </div>
                                            <!-- subtotal -->
                                            <div class="flex flex-col gap-2">
                                                <jet-label
                                                    for="subtotal"
                                                    value="Subtotal"
                                                    class="text-lg font-semibold"
                                                />
                                                <jet-input
                                                    id="subtotal"
                                                    type="text"
                                                    class="mt-1 block w-full border-gray-300 shadow-sm"
                                                    autocomplete="subtotal"
                                                    v-model="form.subtotal"
                                                    disabled
                                                />
                                            </div>
                                            <div
                                                class="flex flex-col text-center gap-2">
                                                <jet-button
                                                    class="max-w-xs ml-auto"
                                                    :class="{'opacity-25': form.processing,}"
                                                    :disabled="form.processing"
                                                    type="submit">
                                                    Actualizar
                                                </jet-button>
                                            </div>
                                        </form>
                                    </Modal>
                                </td>
                                <QuestionAlert 
                                    :show="questionAlert === index" 
                                    question="¿Desea Eliminar del Carrito?"
                                    :info="`Eliminar ${item.producto.nombre_producto} del Carrito`"
                                    @close="questionAlert = null" 
                                    @continues="eliminaritem(item)"
                                />
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </section>
        <!-- 
    ----------- Contenido del modal ----------
    <transition name="modal" appear>
      <div v-if="isAddToCartModalOpen" class="fixed inset-0 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
          <transition name="ease-in-out duration-300">
            <div v-if="isAddToCartModalOpen" class="fixed inset-0 transition-opacity">
              <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
          </transition>

          <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;

          <transition name="modal" appear>
            <div v-if="isAddToCartModalOpen" class="fixed inset-0 overflow-y-auto">
              <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                ---------------- ... Otro contenido ... ---------------

                ---------------- ... Otro contenido ... ---------------

                <transition name="modal" appear>
                  <div v-if="isAddToCartModalOpen" class="fixed inset-0 overflow-y-auto">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                      ------------- ... Otro contenido ... ------------

                      <transition name="modal" appear>
                        <div v-if="isAddToCartModalOpen"
                          class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                          <div class="bg-white sm:p-6 sm:pb-4">
                            <div class="sm sm:items-start">
                              <div class="max-w-7xl mx sm:px lg:px-4">

                                <div>
                                  <div>

                                    ------------- numero_tarjeta ------------
                                    <div>
                                      <label for="numero_tarjeta" class="block text-sm font-medium text-gray-700">Número
                                        de la Tarjeta</label>
                                      <div>
                                        <input v-model="numero_tarjeta" id="numero_tarjeta" name="numero_tarjeta"
                                          type="text" inputmode="numeric" pattern="[0-9\s]{13,19}"
                                          title="Ingrese un número de tarjeta de crédito válido"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                          required>
                                      </div>
                                    </div>

                                    ----------------- Fecha de expiración ----------------
                                    <label for="fecha_expiracion" class="block text-sm font-medium text-gray-700">Fecha de
                                      expiración</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                      <input v-model="fecha_expiracion" id="fecha_expiracion" name="fecha_expiracion"
                                        type="date"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>

                                    ----------------- Nombre en la Tarjeta ----------------
                                    <label for="nombre_tarjeta">Nombre en la Tarjeta</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                      <input v-model="nombre_tarjeta" id="nombre_tarjeta" name="nombre_tarjeta"
                                        type="text"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>

                                    -------------- CVV ---------------
                                    <label for="cvv" class="block text-sm font-medium text-gray-700">CVV</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                      <input v-model="cvv" id="cvv" name="cvv" type="number"
                                        class="mt-1 block w-full px-20 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>

                                    ---------- User ID (No cambiamos esto si se obtiene correctamente de las props) -------
                                    <div class="col-span-6 sm:col-span-4">
                                      <label for="user_id" class="block text-sm font-medium text-gray-700">User ID</label>
                                      <span
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-2 py-1 bg-gray-100">{{
                                          user_id }}</span>
                                      ----------- Display existing card information if available ---------
                                      
                                    </div>
                                    -- Ciudad ---------------
                                    <label v-if="mostrarCasillasEnvio" for="ciudad"
                                      class="block text-sm font-medium text-gray-700">Ciudad</label>
                                    <div v-if="mostrarCasillasEnvio" class="mt-1 flex rounded-md shadow-sm">
                                      <input v-model="datosEnvio.ciudad" id="ciudad" name="ciudad" type="text"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>

                                    ---------- Departamento -------
                                    <label v-if="mostrarCasillasEnvio" for="departamento"
                                      class="block text-sm font-medium text-gray-700">Departamento</label>
                                    <div v-if="mostrarCasillasEnvio" class="mt-1 flex rounded-md shadow-sm">
                                      <input v-model="datosEnvio.departamento" id="departamento" name="departamento"
                                        type="text"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>

                                    ---- Número de Teléfono -------
                                    <label v-if="mostrarCasillasEnvio" for="telefono"
                                      class="block text-sm font-medium text-gray-700">Número de Teléfono</label>
                                    <div v-if="mostrarCasillasEnvio" class="mt-1 flex rounded-md shadow-sm">
                                      <input v-model="datosEnvio.telefono" id="telefono" name="telefono" type="text"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>

                                 --- Carrito ID ------------
                                    <label v-if="mostrarCasillasEnvio" for="carrito_id"
                                      class="block text-sm font-medium text-gray-700">Carrito ID</label>
                                    <div v-if="mostrarCasillasEnvio" class="mt-1 flex rounded-md shadow-sm">
                                      <span
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-2 py-1 bg-gray-100">{{
                                          user_id }}</span>
                                    </div>

                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">

                            <button @click="addItemToCart" type="button"
                              class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                              Pay
                            </button>

                            <button @click="closeAddToCartModal" type="button"
                              class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                              cerrar
                            </button>

                            <button @click="toggleEnvio" :class="{ 'bg-green-600': !conEnvio, 'bg-red-600': conEnvio }"
                              type="button"
                              class="w-full inline-flex justify rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white hover:bg-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-White-500 sm:ml-3 sm:w-auto sm:text-sm">
                              {{ conEnvio ? 'Sin Envío' : 'Con Envío' }}
                            </button>

                          </div>
                        </div>
                      </transition>
                    </div>
                  </div>
                </transition>
              </div>
            </div>
          </transition>
        </div>
      </div>
    </transition> -->
    </AppLayout>
</template>
