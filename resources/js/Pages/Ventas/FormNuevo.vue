<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import { ref, onMounted, watchEffect } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";

const props = defineProps({
    carrito: Array,
    metodosPago: Array,
    departamentos: Array,
    ciudades: Array,
    errors: Object,
});

const items = ref(props.carrito.items);
const isEnvio = ref(true);
const isMetodoTarjeta = ref(true);

const form = useForm({
    _method: "POST",
    /* tabla venta */
    total: "",
    estado: 0,
    tipo_entrega: "tienda",
    metodo_pago_id: null,
    user_id: "",
    /* detalle venta */
    detalle_venta: [],
    /* venta_id: "",
    producto_id: "",
    cantidad_comprada: "",
    subtotal: "", */
    /* datos del envío (si seleccionan opción "envío") */
    telefono: "",
    direccion: "",
    costo_envio: 80000,
    fecha_envio: "",
    estado_envio: "pendiente",
    ciudade_id: null,
    /* datos de la tarjeta (si el pago es con tarjeta) */
    numero_tarjeta: "",
    fecha_expiracion: "",
    nombre_tarjeta: "",
    cvv: "",
});

const handleEnvioFields = (change) => {
    if (change === "able") {
        isEnvio.value = false;
    } else if (change === "disable") {
        isEnvio.value = true;
    }
};

watchEffect(() => {
    const formMetodoPago = form.metodo_pago_id;

    if (formMetodoPago === 1) {
       isMetodoTarjeta.value = false;
    }else{
        isMetodoTarjeta.value = true;
    }
});
const fiveDaysToSend = () => {
    const today = new Date();
    const futureDate = new Date();
    futureDate.setDate(today.getDate() + 5);
    // Formatear la fecha a YYYY-MM-DD
    return futureDate.toISOString().split("T")[0];
};

onMounted(() => {
    /* config date fecha envio */
    const dateConfig = fiveDaysToSend();
    form.fecha_envio = dateConfig;

    /* set subtotal */
    if (props.carrito) {
        const items = props.carrito.items;
        let subtotal = 0;
        items.forEach((item) => {
            subtotal += item.subtotal;
        });
        form.total = subtotal;
    }

    /* set form.detalle_venta */
    const data = items.value;

    data.forEach((itemData) => {
        const objectDetalle = {
            producto_id: itemData.producto.id,
            cantidad: itemData.cantidad,
            subtotal: itemData.subtotal,
        };

        form.detalle_venta.push(objectDetalle);
    });
});


const guardarVentas = () => {
    console.log(form)
    form.post(route("ventas.store"), {
        preserveScroll: true,
    });

};
</script>

<template>
    <app-layout title="Comprar Productos">
        <template #header>
            <h2 class="font-semibold tex-x1 text-gray-800 leading-tight">
                Nuevo Venta
            </h2>
        </template>

        <section class="py-12">
            <div class="max-w-7x1 mx-auto flex flex-col gap-4 sm:px-6 lg:px-8">
                <jet-form-section>
                    <template #title> Resumen de órden </template>
                    <template #descripcion>
                        <p class="text-lg text-gray-600">
                            Resumen e información de la Venta
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
                                <!-- información sobre los productos -->
                                <div
                                    v-for="(producto, index) in items"
                                    :key="producto.id"
                                    class="text-gray-600 border-b py-2">
                                    <span
                                        class="font-medium capitalize underline">
                                        {{ producto.producto.nombre_producto }}
                                    </span>
                                    <div class="text-sm italic">
                                        {{ producto.producto.descripcion }}
                                    </div>
                                    <div class="flex flex-col text-sm">
                                        <div class="pt-1">
                                            <span class="font-medium">Cantidad:</span>
                                            {{ producto.cantidad }}
                                        </div>
                                        <div class="pt-1">
                                            <span class="font-medium">Subtotal:</span>
                                            {{ producto.subtotal }}Gs.
                                        </div>
                                    </div>
                                </div>
                                <!-- total a comprar -->
                                <div>
                                    <span class="font-medium">Total:</span>
                                    {{ form.total }}Gs.
                                </div>
                            </div>
                        </div>
                    </template>
                </jet-form-section>

                <!-- formulario para completar las ventas -->

                <jet-form-section @submitted="guardarVentas">
                    <template #title> Completar Información </template>
                    <template #descripcion>
                        <p class="text-lg text-gray-600">
                            Completar Información para la compra
                        </p>
                    </template>

                    <template #form>
                    <!-- Estado de la venta -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="estado"
                                value="Estado de la Venta"
                                class="text-lg font-semibold"
                            />
                            <select
                                id="estado"
                                class="mt-1 block w-full border-gray-300 bg-gray-200 rounded-3xl shadow focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                v-model="form.estado"
                                disabled>
                                <option :value="0">Pendiente</option>
                            </select>
                            <jet-input-error
                                :message="errors.estado"
                                class="mt-2 text-red-500"
                            />
                        </div>
                        <!-- tipo de entrega -->
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
                                        @input="handleEnvioFields('disable')"
                                    />
                                    Entrega en tienda
                                </label>
                                <label class="font-medium">
                                    <input
                                        type="radio"
                                        name="tipo_entrega"
                                        value="envio"
                                        v-model="form.tipo_entrega"
                                        @input="handleEnvioFields('able')"
                                    />
                                    Envío
                                </label>
                            </fieldset>
                            <jet-input-error
                                :message="errors.tipo_entrega"
                                class="mt-2 text-red-500"
                            />
                        </div>
                        <!-- teléfono -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="telefono"
                                value="Teléfono"
                                class="text-lg font-semibold"
                            />
                            <jet-input
                                id="telefono"
                                type="text"
                                class="mt-1 block w-full border-gray-300 shadow-sm"
                                v-model="form.telefono"
                                autocomplete="telefono"
                                :disabled="isEnvio"
                            />
                            <jet-input-error
                                :message="errors.telefono"
                                class="mt-2 text-red-500"
                            />
                        </div>
                        <!-- departamento -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="departamento"
                                value="Departamento"
                                class="text-lg font-semibold"
                            />
                            <select
                                id="departamento"
                                class="mt-1 block w-full border-gray-300 rounded-3xl shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                :class="{
                                    'bg-gray-200': isEnvio,
                                    'bg-white': !isEnvio,}"
                                :disabled="isEnvio">
                                <option
                                    :value="null"
                                    class="text-gray-400"
                                    selected
                                    disabled>
                                    Seleccionar Departamento
                                </option>
                                <option
                                    v-for="departamento in departamentos"
                                    :key="departamento.id"
                                    :value="departamento.id">
                                    {{ departamento.nombre }}
                                </option>
                            </select>
                        </div>
                        <!-- ciudade_id -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="ciudade_id"
                                value="Ciudad"
                                class="text-lg font-semibold"
                            />
                            <select
                                id="ciudade_id"
                                class="mt-1 block w-full border-gray-300 rounded-3xl shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                v-model="form.ciudade_id"
                                :class="{
                                    'bg-gray-200': isEnvio,
                                    'bg-white': !isEnvio,}"
                                :disabled="isEnvio">
                                <option
                                    :value="null"
                                    class="text-gray-400"
                                    selected
                                    disabled>
                                    Seleccionar Ciudad
                                </option>
                                <option
                                    v-for="ciudade in ciudades"
                                    :key="ciudade.id"
                                    :value="ciudade.id">
                                    {{ ciudade.nombre_ciudad }}
                                </option>
                            </select>
                            <jet-input-error
                                :message="errors.ciudade_id"
                                class="mt-2 text-red-500"
                            />
                        </div>
                        <!-- dirección -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="direccion"
                                value="Direccion"
                                class="text-lg font-semibold"
                            />
                            <jet-input
                                id="direccion"
                                type="text"
                                class="mt-1 block w-full border-gray-300 shadow-sm"
                                v-model="form.direccion"
                                autocomplete="direccion"
                                :disabled="isEnvio"
                            />
                            <jet-input-error
                                :message="errors.direccion"
                                class="mt-2 text-red-500"
                            />
                        </div>
                        <!-- costo envío -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="costo_envio"
                                value="Costo Envío"
                                class="text-lg font-semibold"
                            />
                            <jet-input
                                id="costo_envio"
                                type="text"
                                class="mt-1 block w-full border-gray-300 shadow-sm"
                                v-model="form.costo_envio"
                                autocomplete="costo_envio"
                                :disabled="true"
                            />
                            <jet-input-error
                                :message="errors.costo_envio"
                                class="mt-2 text-red-500"
                            />
                        </div>
                        <!-- fecha envío -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="fecha_envio"
                                value="Fecha Envío"
                                class="text-lg font-semibold"
                            />
                            <jet-input
                                id="fecha_envio"
                                type="date"
                                class="mt-1 block w-full border-gray-300 shadow-sm"
                                v-model="form.fecha_envio"
                                autocomplete="fecha_envio"
                                :disabled="true"
                            />
                            <jet-input-error
                                :message="errors.fecha_envio"
                                class="mt-2 text-red-500"
                            />
                        </div>
                        <!-- Estado del Envío -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="estado_envio"
                                value="Estado Envío"
                                class="text-lg font-semibold"
                            />
                            <select
                                id="estado_envio"
                                class="mt-1 block w-full bg-gray-200 border-gray-300 rounded-3xl shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                v-model="form.estado_envio"
                                :disabled="true">
                                <option
                                    class="text-gray-400"
                                    selected
                                    value="pendiente">
                                    Pendiente
                                </option>
                                <option>Enviado</option>
                                <option>Terminado</option>
                            </select>
                            <jet-input-error
                                :message="errors.estado_envio"
                                class="mt-2 text-red-500"
                            />
                        </div>
                    </template>
                </jet-form-section>
                <!-- Métodos de Pago Formulario -->
                <jet-form-section @submitted="guardarVentas">
                    <template #title> Completar Compra </template>
                    <template #descripcion>
                        <p class="text-lg text-gray-600">Completar la Venta</p>
                    </template>
                    <template #form>
                    <!-- Método de Pago -->
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
                                    selected
                                    disabled>
                                    Seleccionar Método
                                </option>
                                <option
                                    v-for="metodoPago in metodosPago"
                                    :key="metodoPago.id"
                                    :value="metodoPago.id">
                                    {{ metodoPago.metodo }}
                                </option>
                            </select>
                            <jet-input-error
                                :message="errors.metodo_pago_id"
                                class="mt-2 text-red-500"
                            />
                        </div>
                        <!-- nombre de la tarjeta -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="nombre_tarjeta"
                                value="Nombre de la tarjeta"
                                class="text-lg font-semibold"
                            />
                            <jet-input
                                id="nombre_tarjeta"
                                type="text"
                                class="mt-1 block w-full border-gray-300 shadow-sm"
                                v-model="form.nombre_tarjeta"
                                autocomplete="nombre_tarjeta"
                                :disabled="isMetodoTarjeta"
                            />
                            <jet-input-error
                                :message="errors.nombre_tarjeta"
                                class="mt-2 text-red-500"
                            />
                        </div>
                        <!-- número de la tarjeta -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="numero_tarjeta"
                                value="Número de Tarjeta"
                                class="text-lg font-semibold"
                            />
                            <jet-input
                                id="numero_tarjeta"
                                type="text"
                                class="mt-1 block w-full border-gray-300 shadow-sm"
                                v-model="form.numero_tarjeta"
                                autocomplete="numero_tarjeta"
                                :disabled="isMetodoTarjeta"
                            />
                            <jet-input-error
                                :message="errors.numero_tarjeta"
                                class="mt-2 text-red-500"
                            />
                        </div>
                        <!-- fecha de expiración -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="fecha_expiracion"
                                value="Fecha de Expiración"
                                class="text-lg font-semibold"
                            />
                            <jet-input
                                id="fecha_expiracion"
                                type="date"
                                class="mt-1 block w-full border-gray-300 shadow-sm"
                                v-model="form.fecha_expiracion"
                                autocomplete="fecha_expiracion"
                                :disabled="isMetodoTarjeta"
                            />
                            <jet-input-error
                                :message="errors.fecha_expiracion"
                                class="mt-2 text-red-500"
                            />
                        </div>
                        <!-- cvv -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="cvv"
                                value="CVV"
                                class="text-lg font-semibold"
                            />
                            <jet-input
                                id="cvv"
                                type="text"
                                class="mt-1 block w-full border-gray-300 shadow-sm"
                                v-model="form.cvv"
                                autocomplete="cvv"
                                :disabled="isMetodoTarjeta"
                            />
                            <jet-input-error
                                :message="errors.cvv"
                                class="mt-2 text-red-500"
                            />
                        </div>
                    </template>
                    <template #actions>
                        <jet-button
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            type="submit">
                            Completar Compra
                        </jet-button>
                    </template>
                </jet-form-section>
            </div>
        </section>
    </app-layout>
</template>
