<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";

const props = defineProps({
    publicars: Object,
    productos: Array,
    errors: Object,
});

const form = useForm({
    _method: "PUT",
    id: props.publicars.id,
    precio_venta: props.publicars.precio_venta,
    detalle: props.publicars.detalle,
    estado: props.publicars.estado,
    imagen_url: props.publicars.imagen_url,
    producto_id: props.publicars.producto_id,
});

const handleImageUpload = (event) => {
    // Captura la imagen seleccionada por el usuario
    const file = event.target.files[0];
    form.imagen_url = file; // Asigna la imagen al formulario
};

const actualizarPublicar = () => {
    const formData = new FormData();
    for (const key in form) {
        formData.append(key, form[key]);
    }

    // Enviar la solicitud con Inertia
    form.post(route("publicar.update", form.id), {
        data: formData,
        preserveScroll: true,
    });
};
</script>
<template>
    <app-layout title="Editar Publicación">
        <template #header>
            <h2 class="text-md font-bold text-primary leading-tight">
                Editar Publicación
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7x1 mx-auto">
                <jet-form-section @submitted="actualizarPublicar">
                    <template #title>
                        <div class="text-base font-bold text-primary">
                            Información sobre la Publicación
                        </div>
                    </template>
                    <template #descripcion>
                        Actualizar información de Producto
                    </template>
                    <template #form>
                        <!-- nombre_producto -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="id_producto"
                                value="producto"
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

                        <!-- precio -->
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
                            /><!-- SI el usuario no desea cambiar la imagen, entonces no es necesario arrojar error? -->
                        </div>
                    </template>
                    <template #actions>
                        <jet-action-message
                            :on="form.recentlySuccessful"
                            class="mr-3">
                            Registro Actualizado
                        </jet-action-message>

                        <jet-button
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            type="submit">
                            Actualizar
                        </jet-button>
                    </template>
                </jet-form-section>
            </div>
        </div>
    </app-layout>
</template>
