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
import { onMounted } from "vue";

const props = defineProps({
    envio: Array,
    departamentos: Array,
    ciudades: Array,
    errors: Object,
});

const form = useForm({
    _method: "PUT",
    id: props.envio.id,
    telefono: props.envio.telefono,
    direccion: props.envio.direccion,
    costo_envio: props.envio.costo_envio,
    fecha_envio: props.envio.fecha_envio,
    estado_envio: props.envio.estado_envio,
    ciudade_id: props.envio.ciudade_id,
    departamento_id:props.envio.ciudade.departamento_id
});

const actualizarEnvio = () => {
    form.post(route("envios.update", form.id), {
        preserveScroll: true,
    });
};


</script>

<template>
    <app-layout title="Editar Producto">
        <template #header>
            <h2 class="text-md font-bold text-primary leading-tight">
                Editar Producto
            </h2>
        </template>
        <section class="py-12">
            <div class="max-w-7x1 mx-auto">
                <jet-form-section @submitted="actualizarEnvio">
                    <template #title>Información sobre el Envío</template>
                    <template #descripcion>
                        Actualizar información de Producto
                    </template>

                    <template #form>
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
                                class="mt-1 block w-full bg-white border-gray-300 rounded-3xl shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                v-model="form.departamento_id">
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
                                class="mt-1 block w-full bg-white border-gray-300 rounded-3xl shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                v-model="form.ciudade_id">
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
                                class="mt-1 block w-full bg-white border-gray-300 rounded-3xl shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                v-model="form.estado_envio">
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
                    <template #actions>
                        <!-- <jet-action-message
                            :on="form.recentlySuccessful"
                            class="mr-3">
                            Registro Actualizado
                        </jet-action-message> -->
                        <jet-button
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            type="submit">
                            Actualizar
                        </jet-button>
                    </template> 
                </jet-form-section>
            </div>
        </section>
    </app-layout>
</template>
