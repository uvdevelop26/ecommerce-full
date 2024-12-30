<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import FlashMessage from "../../Components/FlashMessage.vue";
import QuestionAlert from "../../Components/QuestionAlert.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import Pagination from "../../Components/Pagination.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetButton from "@/Jetstream/Button.vue";
import Edit from "../../Components/icons/Edit.vue";
import Delete from "../../Components/icons/Delete.vue";
import { Inertia } from "@inertiajs/inertia";
import Modal from "../../Components/Modal.vue";
import Utilities from "../../Utilities";
import { reactive, watchEffect, ref, onMounted, computed } from "vue";
import { pickBy } from "lodash";
import { Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    categorias: Array,
    flash: Object,
    errors: Object,
});

//flash message
const flashMessage = ref("");
const questionAlert = ref(null);
const successMessage = computed(() => props.flash.message);

//edit
const modalEdit = ref(null);
const formEdit = useForm({
    _method: "PUT",
    id: "",
    nombre_categoria: "",
});

//create categories
const createCatOpen = ref(null);
const form = useForm({
    id: null,
    nombre_categoria: null,
});

const showOnModal = (index) => {
    const categorias = props.categorias.data;
    formEdit.id = categorias[index].id;
    formEdit.nombre_categoria = categorias[index].nombre_categoria;
    modalEdit.value = index;
};

const actualizarCategoria = () => {
    formEdit.post(route("categorias.update", formEdit.id), {
        preserveScroll: true,
        onSuccess: () => {
            modalEdit.value = null;
        },
    });
};

const guardarCategoria = () => {
    form.post(route("categorias.store"), {
        preserveScroll: true, // Evita que la página se desplace al tope.
        onSuccess: () => {
            createCatOpen = false; // Cierra el modal solo si el formulario es válido
            form.reset(); // Limpia el formulario
        },
        onError: () => {
            // Maneja los errores, no necesitas cerrar el modal.
            console.error("Ocurrió un error al guardar la categoría.");
        },
    });
};

const eliminarCategorias = (data) => {
    data._method = "DELETE";
    Inertia.post("/categorias/" + data.id, data);
};

const hideFlashMessage = () => {
    setTimeout(() => {
        flashMessage.value = "";
        props.flash.message = "";
        successMessage.value = "";
    }, 5000);
};

onMounted(() => {
    if (successMessage.value) {
        flashMessage.value = successMessage.value;
        hideFlashMessage();
    }
});
</script>
<template>
    <AppLayout title="Listado de Categorías">
        <!-- Encabezado -->
        <template #header>
            <h2
                class="text-md font-bold text-primary leading-tight flex items-center flex-wrap justify-between max-w-6xl mx-auto"
            >
                Listado de Categorias
                <button
                    type="button"
                    class="px-5 py-2 rounded-3xl text-sm shadow bg-gray-100 font-bold text-primary hover:bg-gray-200"
                    @click="createCatOpen = true"
                >
                    Nuevo
                </button>
            </h2>
        </template>
        <!-- section table -->
        <section class="pb-12 relative">
            <!-- Mensaje Flash -->
            <FlashMessage :success="flashMessage" />
            <!-- tabla -->
            <div class="max-w-6xl mx-auto overflow-x-auto">
                <table
                    class="w-full text-sm whitespace-nowrap border-separate border-spacing-y-2 rounded-md"
                >
                    <thead>
                        <tr class="text-left text-white underline">
                            <th
                                scope="col"
                                class="pb-4 pt-4 px-6 rounded-l-lg bg-secondary"
                            >
                                N°
                            </th>
                            <th scope="col" class="pb-4 pt-4 px-6 bg-secondary">
                                Descripción
                            </th>
                            <th scope="col" class="pb-4 pt-4 px-6 bg-secondary">
                                Fecha de Creación
                            </th>
                            <th
                                scope="col"
                                class="pb-4 pt-4 px-6 rounded-r-lg bg-secondary"
                            >
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="categorias.length === 0">
                            <tr>
                                <td
                                    colspan="6"
                                    class="px-6 py-4 text-center text-sm text-gray-500"
                                >
                                    NO HAY DATOS DE PRODUCTOS PARA MOSTRAR
                                </td>
                            </tr>
                        </template>
                        <template v-else>
                            <tr
                                v-for="(categoria, index) in categorias.data"
                                :key="categoria.id"
                                class="focus-within:bg-gray-100 shadow-md group"
                            >
                                <td
                                    class="rounded-l-lg bg-gray-50 px-6 py-4 group-hover:bg-gray-100"
                                >
                                    {{ index + 1 }}
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100 capitalize"
                                >
                                    {{ categoria.nombre_categoria }}
                                </td>
                                <td
                                    class="bg-gray-50 px-6 py-4 group-hover:bg-gray-100 capitalize"
                                >
                                    {{
                                        Utilities.getFormattedDate(
                                            categoria.created_at
                                        )
                                    }}
                                </td>
                                <td
                                    class="rounded-r-lg bg-gray-50 px-6 py-4 flex items-center gap-4 group-hover:bg-gray-100"
                                >
                                    <button
                                        class="text-sm font-medium text-secondary flex items-center gap-1 hover:underline"
                                        @click.prevent="showOnModal(index)"
                                    >
                                        Editar
                                        <Edit
                                            class="block w-auto h-3 fill-secondary"
                                        />
                                    </button>
                                    <button
                                        type="button"
                                        @click="questionAlert = index"
                                        class="text-sm font-medium text-red-500 flex items-center gap-1 hover:underline"
                                    >
                                        Eliminar
                                        <Delete
                                            class="block w-auto h-3 fill-red-500"
                                        />
                                    </button>
                                    <!-- modal editar -->
                                    <Modal
                                        :show="modalEdit === index"
                                        maxWidth="md"
                                        @close="modalEdit = null"
                                    >
                                        <h3
                                            class="py-2 mb-2 text-center text-sm text-primary font-bold italic border-b"
                                        >
                                            Actualizar Categoría
                                        </h3>
                                        <form
                                            @submit.prevent="
                                                actualizarCategoria
                                            "
                                            class="flex flex-col gap-4"
                                        >
                                            <div class="flex flex-col gap-2">
                                                <jet-label
                                                    for="nombre_categoria"
                                                    value="Nombre de la Categoría"
                                                    class="text-lg font-semibold"
                                                />
                                                <jet-input
                                                    id="nombre_categoria"
                                                    type="text"
                                                    class="mt-1 block w-full border-gray-300 shadow-sm"
                                                    autocomplete="nombre_producto"
                                                    v-model="
                                                        formEdit.nombre_categoria
                                                    "
                                                />
                                                <jet-input-error
                                                    :message="
                                                        errors.nombre_categoria
                                                    "
                                                    class="mt-2 text-red-500"
                                                />
                                            </div>
                                            <div
                                                class="flex flex-col text-center gap-2"
                                            >
                                                <jet-button
                                                    class="max-w-xs ml-auto"
                                                    :class="{
                                                        'opacity-25':
                                                            formEdit.processing,
                                                    }"
                                                    :disabled="
                                                        formEdit.processing
                                                    "
                                                    type="submit"
                                                >
                                                    Actualizar
                                                </jet-button>
                                            </div>
                                        </form>
                                    </Modal>
                                </td>
                                <QuestionAlert
                                    :show="questionAlert === index"
                                    question="¿Desea Eliminar esta Categoría?"
                                    :info="`Eliminar Categoria ${categoria.nombre_categoria}`"
                                    @close="questionAlert = null"
                                    @continues="eliminarCategorias(categoria)"
                                />
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <pagination
                class="mt-6 max-w-7xl mx-auto"
                :links="categorias.links"
                @change-page="(page) => (form.page = page)"
            />
            <!-- create Categories Modal -->
            <Modal
                :show="createCatOpen"
                maxWidth="md"
                @close="createCatOpen = null"
            >
                <h3
                    class="py-2 mb-2 text-center text-sm text-primary font-bold italic border-b"
                >
                    Crear Categoría
                </h3>
                <form
                    @submit.prevent="guardarCategoria"
                    class="flex flex-col gap-4"
                >
                    <div class="flex flex-col gap-2">
                        <jet-label
                            for="nombre_categoria"
                            value="Nombre de la Categoría"
                            class="text-lg font-semibold"
                        />
                        <jet-input
                            id="nombre_categoria"
                            type="text"
                            class="mt-1 block w-full border-gray-300 shadow-sm"
                            autocomplete="nombre_producto"
                            v-model="form.nombre_categoria"
                        />
                        <jet-input-error
                            :message="errors.nombre_categoria"
                            class="mt-2 text-red-500"
                        />
                    </div>
                    <div class="flex flex-col text-center gap-2">
                        <jet-button
                            class="max-w-xs ml-auto"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            type="submit"
                        >
                            Guardar
                        </jet-button>
                    </div>
                </form>
            </Modal>
        </section>
    </AppLayout>
</template>
