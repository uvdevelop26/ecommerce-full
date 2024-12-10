<script setup>
//importaci9nes
import AppLayout from "@/Layouts/AppLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import { Link } from "@inertiajs/inertia-vue3";
import QuestionAlert from "../../Components/QuestionAlert.vue";
import Pagination from "../../Components/Pagination.vue";
import FlashMessage from "../../Components/FlashMessage.vue";
import Edit from "../../Components/icons/Edit.vue";
import Delete from "../../Components/icons/Delete.vue";
import RoundedLink from "../../Components/RoundedLink.vue";
import { reactive, watchEffect, ref, onMounted, computed } from "vue";


const props = defineProps({
    productos: Array,
    flash: Object,
});

const flashMessage = ref("");
const questionAlert = ref(null);

const successMessage = computed(() => props.flash.message);

const hideFlashMessage = () => {
    setTimeout(() => {
        flashMessage.value = "";
        props.flash.message = "";
        successMessage.value = "";
    }, 5000);
};

const eliminarProductos = (data) => {
    data._method = "DELETE";
    Inertia.post("/productos/" + data.id, data);

    questionAlert.value = null;
};

onMounted(() => {
    if (successMessage.value) {
        flashMessage.value = successMessage.value;
        hideFlashMessage();
    }
});
</script>

<template>
    <AppLayout title="Listado de Productos">
        <!-- Encabezado -->
        <template #header>
            <h2
                class="text-md font-bold text-primary leading-tight flex items-center flex-wrap justify-between">
                Listado de Productos
                <RoundedLink
                    :href="route('productos.create')"
                    class="shadow bg-gray-100 font-bold text-primary hover:bg-gray-200">
                    Nuevo
                </RoundedLink>
            </h2>
        </template>

        <section class="pb-12 relative">
         <!-- Mensaje Flash -->
            <FlashMessage :success="flashMessage" />
         <!-- tabla -->
            <div class="max-w-7xl mx-auto overflow-x-auto">
                <table
                    class="w-full text-sm whitespace-nowrap border-separate border-spacing-y-2 rounded-md">
                    <thead>
                        <tr class="text-left text-white underline">
                            <th
                                class="pb-4 pt-4 px-6 rounded-l-lg bg-secondary">
                                N°
                            </th>
                            <th class="pb-4 pt-4 px-6 bg-secondary">Nombre</th>
                            <th class="pb-4 pt-4 px-6 bg-secondary">
                                Descripción
                            </th>
                            <th class="pb-4 pt-4 px-6 bg-secondary">
                                Precio Compra
                            </th>
                            <th class="pb-4 pt-4 px-6 bg-secondary">Stock</th>
                            <th class="pb-4 pt-4 px-6 bg-secondary">
                                Categoría
                            </th>
                            <th class="pb-4 pt-4 px-6 bg-secondary">
                                Proveedor
                            </th>
                            <th class="pb-4 pt-4 px-6 bg-secondary">Usuario</th>
                            <th
                                class="pb-4 pt-4 px-6 rounded-r-lg bg-secondary">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="productos.length === 0">
                            <tr>
                                <td
                                    colspan="6"
                                    class="px-6 py-4 text-center text-sm text-gray-500">
                                    NO HAY DATOS DE PRODUCTOS PARA MOSTRAR
                                </td>
                            </tr>
                        </template>
                        <template v-else>
                            <tr
                                class="focus-within:bg-gray-100 shadow-md group"
                                v-for="(producto, index) in productos.data"
                                :key="producto.id">
                                <td
                                    class="rounded-l-lg bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ index + 1 }}
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ producto.nombre_producto }}
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 max-w-xs overflow-hidden group-hover:bg-gray-100">
                                    {{ producto.descripcion }}
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ producto.precio_compra }} <span class="text-xs">gs.</span>
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ producto.stock }}
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    <span v-if="producto.categoria">
                                        {{
                                            producto.categoria.nombre_categoria
                                        }}
                                    </span>
                                    <span v-else>___</span>
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    <span v-if="producto.proveedore">
                                        {{
                                            producto.proveedore.nombre_proveedor
                                        }}
                                    </span>
                                    <span v-else>___</span>
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ producto.user.name }}
                                </td>
                                <td
                                    class="rounded-r-lg bg-gray-50 px-6 py-4 flex items-center gap-4 group-hover:bg-gray-100">
                                    <Link
                                        :href="route('productos.edit', producto.id)"
                                        class="text-sm font-medium text-secondary flex items-center gap-1 hover:underline">
                                        Editar
                                        <Edit
                                            class="block w-auto h-3 fill-secondary"
                                        />
                                    </Link>
                                    <button
                                        type="button"
                                        @click="questionAlert = index"
                                        class="text-sm font-medium text-red-500 flex items-center gap-1 hover:underline">
                                        Eliminar
                                        <Delete
                                            class="block w-auto h-3 fill-red-500"
                                        />
                                    </button>
                                </td>
                                <QuestionAlert 
                                    :show="questionAlert === index" 
                                    question="¿Desea Eliminar este Producto?"
                                    :info="`Eliminar Producto ${producto.nombre_producto}`"
                                    @close="questionAlert = null" 
                                    @continues="eliminarProductos(producto)"
                                />
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <pagination
                class="mt-6 max-w-7xl mx-auto"
                :links="productos.links"
                @change-page="(page) => (form.page = page)"
            />
        </section>
    </AppLayout>
</template>
