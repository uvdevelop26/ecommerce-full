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
    errors: Object,
});

const form = useForm({
    _method: "POST",
    id: null,
    nombre_proveedor: null,
    informacion_contacto: null,
});

const guardarproveedor = () => {
    form.post(route("proveedores.store"), form);
};
</script>
<template>
    <app-layout title="Nuevo Proveedor">
        <template #header>
            <h2 class="text-md font-bold text-primary leading-tight">
                Nuevo Proveedor
            </h2>
        </template>

        <section class="py-12">
            <div class="max-w-7xl mx-auto">
                <jet-form-section @submitted="guardarproveedor">
                    <template #title>
                        <div class="text-base font-bold text-primary">
                            Información sobre el Proveedor
                        </div>
                    </template>
                    <template #description>
                        <p class="text-sm italic text-gray-600">
                            Agregar Nuevo proveedor
                        </p>
                    </template>
                    <template #form>
                        <!-- Proveedor nombre -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="nombre_proveedor"
                                value="Nombre del Proveedor"
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
                                class="mt-1 block w-full border-gray-300"
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
                        <!--  <jet-action-message
                                :on="form.recentlySuccessful"
                                class="mr-3 text-green-500"
                            >
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
