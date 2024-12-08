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
    proveedores: Array,
    categorias: Array,
    errors: Object,
});

const form = useForm({
    _method: "POST",
    id: null,
    nombre_producto: null,
    descripcion: null,
    precio_compra: null,
    stock: null,
    proveedore_id: null,
    categoria_id: null,
    user: props.user,
});

const guardarProductos = () => {
    form.post(route("productos.store"), form);
};
</script>
<template>
    <app-layout title="Nuevo Producto">
        <template #header>
            <h2 class="text-md font-bold text-primary leading-tight">
                Nuevo Producto
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto">
                <jet-form-section @submitted="guardarProductos">
                    <template #title>
                        <div class="text-base font-bold text-primary">
                            Información sobre el Producto
                        </div>
                    </template>
                    <template #descripcion>
                        <p class="text-sm italic text-gray-600">
                            Actualizar información del Producto
                        </p>
                    </template>
                    <template #form>
                        <!-- nombre_producto -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="nombre_producto"
                                value="Nombre del Producto"
                                class="text-lg font-semibold"
                            />
                            <jet-input
                                id="nombre_producto"
                                type="text"
                                class="mt-1 block w-full border-gray-300 shadow-sm"
                                v-model="form.nombre_producto"
                                autocomplete="nombre_producto"
                            />
                            <jet-input-error
                                :message="errors.nombre_producto"
                                class="mt-2 text-red-500"
                            />
                        </div>
                        <!-- descripcion -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="descripcion"
                                value="Descripción"
                                class="text-lg font-semibold"
                            />
                            <jet-input
                                id="descripcion"
                                type="text"
                                class="mt-1 block w-full border-gray-300 shadow-sm"
                                v-model="form.descripcion"
                                autocomplete="descripcion"
                            />
                            <jet-input-error
                                :message="errors.descripcion"
                                class="mt-2 text-red-500"
                            />
                        </div>
                        <!-- precio_compra -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="precio_compra"
                                value="Precio de Compra (Gs)"
                                class="text-lg font-semibold"
                            />
                            <jet-input
                                id="precio_compra"
                                type="number"
                                step="1"
                                class="mt-1 block w-full border-gray-300 shadow-sm"
                                v-model="form.precio_compra"
                                autocomplete="precio_compra"
                            />
                            <jet-input-error
                                :message="errors.precio_compra"
                                class="mt-2 text-red-500"
                            />
                        </div>
                        <!-- stock -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="stock"
                                value="Stock"
                                class="text-lg font-semibold"
                            />
                            <jet-input
                                id="stock"
                                type="number"
                                step="1"
                                class="mt-1 block w-full border-gray-300 shadow-sm"
                                v-model="form.stock"
                                autocomplete="stock"
                            />
                            <jet-input-error
                                :message="errors.stock"
                                class="mt-2 text-red-500"
                            />
                        </div>
                        <!-- id_proveedor -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="id_proveedor"
                                value="Proveedor"
                                class="text-lg font-semibold"
                            />
                            <select
                                id="id_proveedor"
                                class="mt-1 block w-full border-gray-300 rounded-3xl shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                v-model="form.proveedore_id">
                                <option
                                    :value="null"
                                    class="text-gray-400"
                                    disabled>
                                    Seleccionar Proveedor
                                </option>
                                <option
                                    v-for="proveedor in proveedores"
                                    :key="proveedor.id"
                                    :value="proveedor.id">
                                    {{ proveedor.nombre_proveedor }}
                                </option>
                            </select>
                        </div>

                        <!-- id_categoria -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label
                                for="id_categoria"
                                value="Categoria"
                                class="text-lg font-semibold"
                            />
                            <select
                                id="id_categoria"
                                class="mt-1 block w-full border-gray-300 rounded-3xl shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                v-model="form.categoria_id">
                                <option
                                    :value="null"
                                    class="text-gray-400"
                                    disabled>
                                    Seleccionar Categoría
                                </option>
                                <option
                                    v-for="categoria in categorias"
                                    :key="categoria.id"
                                    :value="categoria.id">
                                    {{ categoria.nombre_categoria }}
                                </option>
                            </select>
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
