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
    nombre_categoria: null,
});

const guardarCategoria = () => {
    form.post(route("categorias.store"), form);
};
</script>
<template>
    <app-layout title="Nueva Categoría">
        <template #header>
            <h2 class="text-md font-bold text-primary leading-tight">
                Nueva Categoria
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7x1 mx-auto">
                <jet-form-section @submitted="guardarCategoria">
                    <template #title>
                        <div class="text-base font-bold text-primary">
                            Información de la Categoría
                        </div>
                    </template>
                    <template #descripcion>
                        <p class="text-sm italic text-gray-600">
                            Agregar Nueva Categoria
                        </p>
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
                            class="mr-3 text-green-500">
                            Registro Guardado
                        </jet-action-message>

                        <jet-button
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            type="submit">
                            Guardar
                        </jet-button>
                    </template>
                </jet-form-section>
            </div>
        </div>
    </app-layout>
</template>
