<script setup>
//importaci9nes
import AppLayout from "@/Layouts/AppLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import { Link } from "@inertiajs/inertia-vue3";
import RoundedLink from "../../Components/RoundedLink.vue";
import Pagination from "../../Components/Pagination.vue";
import Edit from "../../Components/icons/Edit.vue";
import Delete from "../../Components/icons/Delete.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";

const props = defineProps({
    publicars: Array,
});

const eliminarPublicar = (data) => {
    data._method = "DELETE";
    Inertia.post("/publicar/" + data.id, data);
};
</script>

<template>
    <AppLayout title="Listado de Publicaciones">
        <!-- Encabezado -->
        <template #header>
            <h2
                class="text-md font-bold text-primary leading-tight flex items-center flex-wrap justify-between">
                Listado de Publicaciones
                <RoundedLink
                    :href="route('publicar.create')"
                    class="shadow bg-gray-100 font-bold text-primary hover:bg-gray-200">
                    Nuevo
                </RoundedLink>
            </h2>
        </template>
        <section class="pb-12">
            <div class="max-w-7xl mx-auto overflow-x-auto">
                <table
                    class="w-full text-sm whitespace-nowrap border-separate border-spacing-y-2 rounded-md">
                    <thead>
                        <tr class="text-left text-white underline">
                            <th
                                class="pb-4 pt-4 px-6 rounded-l-lg bg-secondary">
                                N°
                            </th>
                            <th class="pb-4 pt-4 px-6 bg-secondary">
                                Producto
                            </th>
                            <th class="pb-4 pt-4 px-6 bg-secondary">
                                Estado
                            </th>
                            <th class="pb-4 pt-4 px-6 bg-secondary">
                                Precio Compra
                            </th>
                            <th class="pb-4 pt-4 px-6 bg-secondary">
                                Precio Venta
                            </th>
                            <th class="pb-4 pt-4 px-6 bg-secondary">
                                Cantidad
                            </th>
                            <th class="pb-4 pt-4 px-6 bg-secondary">
                                Detalles
                            </th>
                            <th
                                class="pb-4 pt-4 px-6 rounded-r-lg bg-secondary">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="publicars.length === 0">
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
                                v-for="(publicar, index) in publicars.data"
                                :key="publicar.id">
                                <td
                                    class="rounded-l-lg bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ index + 1 }}
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    <span class="text-xs font-bold underline capitalize">{{ publicar.producto.nombre_producto }}</span> 
                                    <div class="w-11 h-11 overflow-hidden shadow">
                                        <img :src="`images/${publicar.imagen_url}`"
                                        class="w-full h-full object-cover" 
                                        :alt="publicar.imagen_url" />
                                     </div>
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    <span v-if="publicar.estado === 1" class="text-secondary font-medium">
                                      Activo
                                    </span>
                                    <span v-else class="text-red-500 font-medium">Inactivo</span>
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ publicar.producto.precio_compra }}<span class="text-xs">gs.</span>
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ publicar.precio_venta }}<span class="text-xs">gs.</span>
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ publicar.producto.stock }}
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 max-w-xs overflow-hidden group-hover:bg-gray-100">
                                    {{ publicar.detalle }}
                                </td>
                                <td
                                    class="rounded-r-lg bg-gray-50 px-6 py-4 gap-4 group-hover:bg-gray-100">
                                    <Link
                                        :href="route('publicar.edit', publicar.id)"
                                        class="text-sm font-medium text-secondary inline-block mr-2 hover:underline">
                                        Editar
                                        <Edit
                                            class="inline-block w-auto h-3 fill-secondary"
                                        />
                                    </Link>
                                    <Link
                                        @click="eliminarPublicar(publicar)"
                                        class="text-sm font-medium text-red-500 inline-block hover:underline">
                                        Eliminar
                                        <Delete
                                            class="inline-block w-auto h-3 fill-red-500"
                                        />
                                    </Link>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <pagination
                class="mt-6 max-w-7xl mx-auto"
                :links="publicars.links"
                @change-page="(page) => (form.page = page)"
            />
        </section>
    </AppLayout>
</template>
