<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Edit from "../../Components/icons/Edit.vue";
import Delete from "../../Components/icons/Delete.vue";
import QuestionAlert from "../../Components/QuestionAlert.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import FlashMessage from "../../Components/FlashMessage.vue";
import JetButton from "@/Jetstream/Button.vue";
import { Inertia } from "@inertiajs/inertia";
import JetInput from "@/Jetstream/Input.vue";
import { reactive, watchEffect, ref, onMounted, computed } from "vue";

import { pickBy } from "lodash";
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps({
    envios: Array,
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

const eliminardatosenvio = (data) => {
    data._method = "DELETE";
    Inertia.post("/datosenvio/" + data.id, data);

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
    <AppLayout title="Listado de Envíos">
        <template #header>
            <h2
                class="text-md font-bold text-primary leading-tight flex items-center flex-wrap justify-between">
                Listado de Envios
            </h2>
        </template>

        <section class="py-12 relative">
            <!-- Mensaje Flash -->
            <FlashMessage :success="flashMessage" />
            <!-- tabla -->
            <div class="max-w-7xl mx-auto overflow-x-auto">
                <table
                    class="w-full text-sm whitespace-nowrap border-separate border-spacing-y-2 rounded-md">
                    <thead>
                        <tr class="text-left text-white underline">
                            <th
                                scope="col"
                                class="pb-4 pt-4 px-6 rounded-l-lg bg-secondary">
                                N°
                            </th>
                            <th scope="col" class="pb-4 pt-4 px-6 bg-secondary">
                                Código Venta
                            </th>
                            <th scope="col" class="pb-4 pt-4 px-6 bg-secondary">
                                Ciudad
                            </th>
                            <th scope="col" class="pb-4 pt-4 px-6 bg-secondary">
                                Departamento
                            </th>
                            <th scope="col" class="pb-4 pt-4 px-6 bg-secondary">
                                Telefono
                            </th>
                            <th scope="col" class="pb-4 pt-4 px-6 bg-secondary">
                                Costo Envío
                            </th>
                            <th scope="col" class="pb-4 pt-4 px-6 bg-secondary">
                                Fecha Envío
                            </th>
                            <th scope="col" class="pb-4 pt-4 px-6 bg-secondary">
                                Estado
                            </th>
                            <th scope="col" class="pb-4 pt-4 px-6 bg-secondary">
                                Usuario
                            </th>
                            <th scope="col" class="pb-4 pt-4 px-6 bg-secondary">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="envios.length === 0">
                            <tr>
                                <td
                                    colspan="6"
                                    class="px-6 py-4 text-center text-sm text-gray-500">
                                    NO HAY DATOS DE ENVIOS PARA MOSTRAR
                                </td>
                            </tr>
                        </template>
                        <template v-else>
                            <tr
                                class="focus-within:bg-gray-100 shadow-md group"
                                v-for="(envio, index) in envios"
                                :key="envio.id">
                                <td
                                    class="rounded-l-lg bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ index + 1 }}
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ envio.venta.id }}
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ envio.ciudade.nombre_ciudad }}
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ envio.ciudade.departamento.nombre }}
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ envio.telefono }}
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ envio.costo_envio }}
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ envio.fecha_envio }}
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ envio.estado_envio }}
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ envio.venta.user.name }}
                                </td>

                                <td
                                    class="rounded-r-lg bg-gray-50 px-6 py-4 flex items-center gap-4 group-hover:bg-gray-100">
                                    <Link
                                        :href="route('envios.edit', envio.id)"
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
                                    question="¿Desea Eliminar este Envío?"
                                    :info="`Eliminar envio a ${envio.venta.user.name }`"
                                    @close="questionAlert = null" 
                                    @continues="eliminardatosenvio(envio)"
                                />
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </section>
    </AppLayout>
</template>
