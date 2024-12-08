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
    proveedores: Array,
    errors: Object,
});

const form = useForm({
    _method: "PUT",
    id: props.proveedores.id,
    nombre_proveedor: props.proveedores.nombre_proveedor,
    informacion_contacto: props.proveedores.informacion_contacto,
});

const actualizarproveedor = () => {
    form.post(route("proveedores.update", props.proveedores.id), {
        preserveScroll: true,
    });
};


</script>
<template>
    <app-layout title="Editar Proveedor">
        <template #header>
            <h2 class="font-semibold tex-x1 text-gray-800 leading-tight">
                Editar Proveedor
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto">
                <jet-form-section @submitted="actualizarproveedor">
                    <template #title>
                        <div class="text-base font-bold text-primary">
                            Información sobre el Proveedor
                        </div>
                    </template>

                    <template #descripcion>
                        Actualizar informacion de Proveedor
                    </template>

                    <template #form>
                        <!-- Proveedor nombre -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="nombre_proveedor"
                                value="Nombre Proveedor"
                                class="text-lg font-semibold"
                            />
                            <jet-input
                                id="nombre_proveedor"
                                type="text"
                                class="mt-1 block w-full border-gray-300 shadow-sm"
                                v-model="form.nombre_proveedor"
                                autocomplete="nombre_proveedor"
                            />
                            <jet-input-error
                                :message="errors.nombre_proveedor"
                                class="mt-2 text-red-500"
                            />
                        </div>
                        <!-- info contcto -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="informacion_contacto"
                                value="Información"
                                class="text-lg font-semibold"
                            />
                            <jet-input
                                id="informacion_contacto"
                                type="text"
                                class="mt-1 block w-full border-gray-300 shadow-sm"
                                v-model="form.informacion_contacto"
                                autocomplete="informacion_contacto"
                            />
                            <jet-input-error
                                :message="errors.informacion_contacto"
                                class="mt-2 text-red-500"
                            />
                        </div>
                    </template>

                    <template #actions>
                        <jet-action-message
                            :on="form.recentlySuccessful"
                            class="mr-3">
                            Registro Actualizado
                        </jet-action-message>

                        <jet-button
                            class="mr-2 mb-2"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing">
                            Actualizar
                        </jet-button>
                    </template>
                </jet-form-section>
            </div>
        </div>
    </app-layout>
</template>
