<script setup>
//importaci9nes
import AppLayout from "@/Layouts/AppLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import { Link } from "@inertiajs/inertia-vue3";
import ArrowRight from "../../Components/icons/ArrowRight.vue";
import { reactive, watchEffect, ref, onMounted, computed } from "vue";
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import FlashMessage from "../../Components/FlashMessage.vue";


const props = defineProps({
    ventas: Array,
    flash: Object
});

const flashMessage = ref("");

const successMessage = computed(() => props.flash.message);

const hideFlashMessage = () => {
    setTimeout(() => {
        flashMessage.value = "";
        props.flash.message = "";
        successMessage.value = "";
    }, 5000);
};

const eliminarVentas = (data) => {
    data._method = "DELETE";
    Inertia.post("/ventas/" + data.id, data);
};

onMounted(() => {
    if (successMessage.value) {
        flashMessage.value = successMessage.value;
        hideFlashMessage();
    }
});
</script>

<template>
    <AppLayout title="Listado de Ventas">
        <!-- Encabezado -->
        <template #header>
            <h2
                class="text-md font-bold text-primary leading-tight flex items-center flex-wrap justify-between">
                Listado de Productos
                <!-- <Link :href="route('ventas.create')" class="float-right">
                    <jet-button>Nuevo</jet-button>
                </Link> -->
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
                                Total
                            </th>
                            <th scope="col" class="pb-4 pt-4 px-6 bg-secondary">
                                Estado de la Venta
                            </th>
                            <th scope="col" class="pb-4 pt-4 px-6 bg-secondary">
                                Tipo de Entrega
                            </th>
                            <th scope="col" class="pb-4 pt-4 px-6 bg-secondary">
                                Pago Por
                            </th>
                            <th scope="col" class="pb-4 pt-4 px-6 bg-secondary">
                                Usuario
                            </th>
                            <th scope="col" class="pb-4 pt-4 px-6 bg-secondary">
                                Ver Detalles
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="ventas.length === 0">
                            <tr>
                                <td
                                    colspan="8"
                                    class="px-6 py-4 text-center text-sm text-gray-500">
                                    NO HAY DATOS DE PRODUCTOS PARA MOSTRAR
                                </td>
                            </tr>
                        </template>
                        <template v-else>
                            <tr
                                v-for="(venta, index) in ventas"
                                :key="venta.id"
                                class="focus-within:bg-gray-100 shadow-md group">
                                <td
                                    class="rounded-l-lg bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ index + 1 }}
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ venta.total }}Gs.
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    <span
                                        v-if="venta.estado === 0"
                                        class="text-red-600">
                                        Pendiente
                                    </span>
                                    <span v-else class="text-green-500">
                                        Completado
                                    </span>
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100 capitalize">
                                    {{ venta.tipo_entrega }}
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100 capitalize">
                                    {{ venta.metodo_pago.metodo }}
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100">
                                    {{ venta.user.name }}
                                </td>
                                <td
                                    class="rounded-r-lg bg-gray-50 px-6 py-4 gap-4 group-hover:bg-gray-100">
                                    <Link :href="route('ventas.show', venta.id)"
                                        class="flex w-9 h-9 rounded-full bg-emerald-100 shadow justify-center items-center hover:shadow-md">
                                       
                                        <ArrowRight
                                            class="inline-block w-auto h-3 fill-secondary"
                                        />
                                    </Link>
                                    
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </section>
    </AppLayout>
</template>
