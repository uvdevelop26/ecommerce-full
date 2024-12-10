<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";

const props = defineProps({
    user: Array,
    productos: Array,
    errors: Object,
});

const form = useForm({
    _method: "POST",
    id: null,
    precio_venta: null,
    detalle: null,
    estado: null,
    imagen_url: null, // Agrega una propiedad para la imagen
    producto_id: null,
    user: props.user,
});

const handleImageUpload = (event) => {
    // Captura la imagen seleccionada por el usuario
    const file = event.target.files[0];
    form.imagen_url = file; // Asigna la imagen al formulario
};

const guardarPublicar = () => {
    // Crea un objeto FormData para enviar los datos y la imagen
    const formData = new FormData();
    formData.append("precio_venta", form.precio_venta);
    formData.append("detalle", form.detalle);
    formData.append("estado", form.estado);
    formData.append("imagen_url", form.imagen_url); // Agrega la imagen al formulario
    formData.append("producto_id", form.id_producto);
    formData.append("user", form.user);

    // Realiza la petición POST a la ruta utilizando Inertia
    form.post(route("publicar.store"), formData);
};
</script>

<template>
    <app-layout title="Nueva Publicación">
    <!-- Encabezado -->
        <template #header>
            <h2 class="text-md font-bold text-primary leading-tight">
                Nueva Publicacion
            </h2>
        </template>
        <!-- sección -->
        <section class="py-12">
            <div class="max-w-7x1 mx-auto">
                <jet-form-section @submitted="guardarPublicar">
                    <template #title>
                        <div class="text-base font-bold text-primary">
                            Información sobre la Publicación
                        </div>
                    </template>
                    <template #descripcion>
                        <p class="text-lg text-gray-600">
                            Actualizar información de la Publicacion
                        </p>
                    </template>
                    <template #form>
                        <!-- id_producto -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="id_producto"
                                value="Producto"
                                class="text-lg font-semibold"
                            />
                            <select
                                id="id_producto"
                                class="mt-1 block w-full border-gray-300 rounded-3xl shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                v-model="form.producto_id">
                                <option
                                    :value="null"
                                    class="text-gray-400"
                                    disabled>
                                    Seleccionar Producto
                                </option>
                                <option
                                    v-for="producto in productos"
                                    :key="producto.id"
                                    :value="producto.id">
                                    {{ producto.nombre_producto }}
                                </option>
                            </select>
                            <jet-input-error
                                :message="errors.producto_id"
                                class="mt-2 text-red-500"
                            />
                        </div>
                        <!-- precio venta -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="precio_venta"
                                value="Precio"
                                class="text-lg font-semibold"
                            />
                            <jet-input
                                id="precio_venta"
                                type="number"
                                step="1"
                                class="mt-1 block w-full border-gray-300 shadow-sm"
                                v-model="form.precio_venta"
                                autocomplete="precio_venta"
                            />
                            <jet-input-error
                                :message="errors.precio_venta"
                                class="mt-2 text-red-500"
                            />
                        </div>
                        <!-- detalles -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="detalle"
                                value="Detalle (KG, Bolsa(KG))"
                                class="text-lg font-semibold"
                            />
                            <jet-input
                                id="detalle"
                                type="text"
                                class="mt-1 block w-full border-gray-300 shadow-sm"
                                v-model="form.detalle"
                                autocomplete="detalles"
                            />
                            <jet-input-error
                                :message="errors.detalle"
                                class="mt-2 text-red-500"
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
                                <option
                                    :value="null"
                                    class="text-gray-400"
                                    disabled>
                                    Seleccionar Estado
                                </option>
                                <option value="1">Activo / Visible</option>
                                <option value="0">Inactivo / Oculto</option>
                            </select>
                            <jet-input-error
                                :message="errors.estado"
                                class="mt-2 text-red-500"
                            />
                        </div>
                        <!-- imagen -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="imagen"
                                value="Imagen"
                                class="text-lg font-semibold"
                            />
                            <input
                                id="imagen"
                                type="file"
                                class="block w-full text-sm text-primary file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-secondary hover:file:bg-emerald-100 cursor-pointer"
                                accept=".jpeg, .jpg, .png"
                                @change="handleImageUpload"
                            />
                            <jet-input-error
                                :message="errors.imagen_url"
                                class="mt-2 text-red-500"
                            />
                        </div>
                        <!-- User -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="user"
                                value="Usuario"
                                class="text-lg font-semibold"
                            />
                            <jet-input
                                id="user"
                                type="text"
                                class="mt-1 block w-full border-gray-300 shadow-sm capitalize"
                                autocomplete="user"
                                v-model="user.name"
                                disabled
                            />
                        </div>
                    </template>
                    <template #actions>
                        <!--  <jet-action-message
                            :on="form.recentlySuccessful"
                            class="mr-3 text-green-500">
                            Registro Guardado
                        </jet-action-message> -->

                        <jet-button
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            type="submit">
                            Guardar
                        </jet-button>
                    </template>
                </jet-form-section>
            </div>
        </section>
    </app-layout>
</template>
