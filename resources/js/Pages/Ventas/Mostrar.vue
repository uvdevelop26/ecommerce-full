<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import dayjs from "dayjs";
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetLabel from "@/Jetstream/Label.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import JetInput from "@/Jetstream/Input.vue";
import { onMounted } from "vue";

const props = defineProps({
    venta: Array,
    metodosPago: Array,
    errors: Object
});

const form = useForm({
    _method: "PUT",
    id: props.venta.id,
    fecha_venta: "",
    total: props.venta.total,
    estado: props.venta.estado,
    tipo_entrega: props.venta.tipo_entrega,
    metodo_pago_id: props.venta.metodo_pago_id,
});

const actualizarVenta = () =>{
    form.post(route("ventas.update", form.id), {
        preserveScroll: true,
    });
}


onMounted(() => {
    /* date config */
    form.fecha_venta = dayjs(props.venta.created_at).format("YYYY-MM-DD");
});
</script>
<template>
    <AppLayout title="Detalles de la Venta">
        <!-- Encabezado -->
        <template #header>
            <h2
                class="text-md font-bold text-primary leading-tight flex items-center flex-wrap justify-between">
                Detalles de La Venta
            </h2>
        </template>
        <!-- section -->
        <section class="pb-12">
            <div class="max-w-7x1 mx-auto flex flex-col gap-4 sm:px-6 lg:px-8">
                <!-- Información de los productos -->
                <jet-form-section>
                    <template #title>
                        <div class="text-base font-bold text-primary">
                            Productos Vendidos
                        </div>
                    </template>
                    <template #descripcion>
                        <p class="text-lg text-gray-600">
                            Detalle de los productos Vendidos
                        </p>
                    </template>

                    <template #form>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="id_producto"
                                value="Producto/s"
                                class="text-lg font-semibold"
                            />
                            <div class="mt-1 flex flex-col gap-2 w-full">
                                <div
                                    v-for="(detalle, index) in venta.detalle_ventas"
                                    :key="detalle.id"
                                    class="text-gray-600 border-b py-2">
                                    <span
                                        class="font-medium capitalize underline">
                                        {{ detalle.producto.nombre_producto }}
                                    </span>
                                    <div class="text-sm italic">
                                        {{ detalle.producto.descripcion }}
                                    </div>
                                    <div class="flex flex-col text-sm">
                                        <div class="pt-1">
                                            <span class="font-medium">
                                                Cantidad:
                                            </span>
                                            {{ detalle.cantidad_comprada }}
                                        </div>
                                        <div class="pt-1">
                                            <span class="font-medium">Subtotal:</span>
                                            {{ detalle.subtotal }}Gs.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </jet-form-section>
                <!-- Editar Venta -->
                <jet-form-section @submitted="actualizarVenta">
                    <template #title>
                        <div class="text-base font-bold text-primary">
                            Venta
                        </div>
                    </template>
                    <template #form>
                        <!-- fecha venta -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="fecha_venta"
                                value="Fecha de la Venta"
                                class="text-lg font-semibold"
                            />
                            <jet-input
                                id="fecha_venta"
                                type="date"
                                class="mt-1 block w-full border-gray-300 shadow-sm"
                                v-model="form.fecha_venta"
                                autocomplete="fecha_venta"
                                disabled
                            />
                        </div>
                        <!-- total -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="total"
                                value="Total Gs."
                                class="text-lg font-semibold"
                            />
                            <jet-input
                                id="total"
                                type="text"
                                class="mt-1 block w-full border-gray-300 shadow-sm capitalize"
                                autocomplete="total"
                                v-model="form.total"
                                disabled
                            />
                        </div>
                        <!-- estado -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="estado"
                                value="Estado"
                                class="text-lg font-semibold"
                            />
                            <select
                                id="estado"
                                class="mt-1 block w-full border-gray-300 rounded-3xl shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                v-model="form.estado">
                                <option :value="null" class="text-gray-400">
                                    Seleccionar Estado
                                </option>
                                <option value="1">Completado</option>
                                <option value="0">Pendiente</option>
                            </select>
                            <jet-input-error
                                :message="errors.estado"
                                class="mt-2 text-red-500"
                            />
                        </div>
                        <!-- tipo entrega -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="tipo_entrega"
                                value="Tipo Entrega"
                                class="text-lg font-semibold"
                            />
                            <fieldset class="flex gap-4 pt-2">
                                <label class="font-medium">
                                    <input
                                        type="radio"
                                        name="tipo_entrega"
                                        value="tienda"
                                        checked
                                        v-model="form.tipo_entrega"
                                    />
                                    Entrega en tienda
                                </label>
                                <label class="font-medium">
                                    <input
                                        type="radio"
                                        name="tipo_entrega"
                                        value="envio"
                                        v-model="form.tipo_entrega"
                                    />
                                    Envío
                                </label>
                            </fieldset>
                             <jet-input-error
                                :message="errors.tipo_entrega"
                                class="mt-2 text-red-500"
                            />
                        </div>
                        <!-- método de pago -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="metodo_pago_id"
                                value="Método de Pago"
                                class="text-lg font-semibold"
                            />
                            <select
                                id="metodo_pago_id"
                                class="mt-1 block w-full border-gray-300 rounded-3xl shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                v-model="form.metodo_pago_id">
                                <option
                                    :value="null"
                                    class="text-gray-400"
                                    disabled>
                                    Seleccionar Método
                                </option>
                                <option
                                    v-for="metodo in metodosPago"
                                    :key="metodo.id"
                                    :value="metodo.id">
                                    {{ metodo.metodo }}
                                </option>
                            </select>
                            <jet-input-error
                                :message="errors.metodo_pago_id"
                                class="mt-2 text-red-500"
                            />
                        </div>
                    </template>
                    <template #actions>
                        <jet-button
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            type="submit">
                            Actualizar Venta
                        </jet-button>
                    </template>
                </jet-form-section>
            </div>
        </section>
    </AppLayout>
</template>
