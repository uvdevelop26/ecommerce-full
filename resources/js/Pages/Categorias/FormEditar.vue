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
    categoria: Array,
    errors: Object
});

const form = useForm({
    _method: "PUT",
    id: props.categoria.id,
    nombre_categoria: props.categoria.nombre_categoria,
});

const actualizarCategoria = () => {
    form.post(route("categorias.update", props.categoria.id), {
        preserveScroll: true,
    });
};
</script>
<template>
    <app-layout title="Editar Categoría">
        <template #header>
            <h2 class="font-semibold tex-x1 text-gray-800 leading-tight">
                Editar Categoría
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto">
                <jet-form-section @submitted="actualizarCategoria">
                    <template #title>
                        <div class="text-base font-bold text-primary">
                            Información sobre la Categoría
                        </div>
                    </template>

                    <template #descripcion>
                        Actualizar informacion de Producto
                    </template>

                    <template #form>
                        <!-- descripcion -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="nombre_categoria"
                                value="Nombre de la Categoría"
                                class="text-lg font-semibold"
                            />
                            <jet-input
                                id="nombre_categoria"
                                type="text"
                                class="mt-1 block w-full border-gray-300 shadow-sm"
                                v-model="form.nombre_categoria"
                                autocomplete="nombre_categoria"
                            />
                            <jet-input-error
                                :message="errors.nombre_categoria"
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
