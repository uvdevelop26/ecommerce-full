<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import RoundedLink from "../../Components/RoundedLink.vue";
import FlashMessage from "../../Components/FlashMessage.vue";
import QuestionAlert from "../../Components/QuestionAlert.vue";
import Edit from "../../Components/icons/Edit.vue";
import Delete from "../../Components/icons/Delete.vue";
import Pagination from "../../Components/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import JetInput from "@/Jetstream/Input.vue";
import { reactive, watchEffect, ref, computed, onMounted } from "vue";
import { pickBy } from "lodash";
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps({
    proveedores: Array,
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

const eliminarproveedores = (data) => {
    data._method = "DELETE";
    Inertia.post("/proveedores/" + data.id, data);

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
    <AppLayout title="Listado de Proveedores">
        <!-- Encabezado -->
        <template #header>
            <h2
                class="text-md font-bold text-primary leading-tight flex items-center flex-wrap justify-between">
                Listado de Proveedores
                <RoundedLink
                    :href="route('proveedores.create')"
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
                                Información
                            </th>
                            <th
                                class="pb-4 pt-4 px-6 rounded-r-lg bg-secondary">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="proveedores.length === 0">
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
                                v-for="(proveedor, index) in proveedores.data"
                                :key="proveedor.id">
                                <td
                                    class="rounded-l-lg bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ index + 1 }}
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ proveedor.nombre_proveedor }}
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ proveedor.informacion_contacto }}
                                </td>
                                <td
                                    class="rounded-r-lg bg-gray-50 px-6 py-4 flex items-center gap-4 group-hover:bg-gray-100">
                                    <Link
                                        :href="route('proveedores.edit', proveedor.id)"
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
                                    question="¿Desea Eliminar este Proveedor?"
                                    :info="`Eliminar Proveedor ${proveedor.nombre_proveedor}`"
                                    @close="questionAlert = null" 
                                    @continues="eliminarproveedores(proveedor)"
                                />
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <pagination
                class="mt-6 max-w-7xl mx-auto"
                :links="proveedores.links"
                @change-page="(page) => (form.page = page)"
            />
        </section>
    </AppLayout>
</template>
