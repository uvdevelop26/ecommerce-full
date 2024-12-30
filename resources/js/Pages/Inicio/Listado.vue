<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import CarritoIcon from "../../Components/icons/CarritoIcon.vue";
import Utilities from "../../Utilities";
import Animations from "../../Animations";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import RoundedLink from "../../Components/RoundedLink.vue";
import FlashMessage from "../../Components/FlashMessage.vue";
import Car from "../../Components/Car.vue";
import { pickBy } from "lodash";
import { router } from "@inertiajs/vue3";
import { reactive, watchEffect, ref, onMounted, computed } from "vue";

const props = defineProps({
    publicars: Array,
    categorias: Array,
    banner: Object,
    flash: Object,
    filters: Object,
});

//filter functions
const form = reactive({
    search: props.filters.search,
});

watchEffect(() => {
    const query = pickBy(form);
    router.replace(
        route("inicio.index", Object.keys(query).length ? query : {}),
        { preserveScroll: true }
    );
});

const filterByCategories = (option) => {
    form.search = option === "all" ? null : option;
};

//flash Message

const flashMessage = ref("");

const successMessage = computed(() => props.flash.message);

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
    <AppLayout
        title="Listado de Productos"
        messageBillboard="Descuento con tu primera Compra">
        <!-- Encabezado -->
        <template #header>
            <h2
                class="text-md font-bold text-primary leading-tight flex items-center flex-wrap justify-between">
                Explora Nuestros Productos
                <div class="flex items-center gap-2">
                    <RoundedLink
                        :href="route('publicar.index')"
                        class="shadow bg-gray-100 font-bold text-primary hover:bg-gray-200">
                        Publicaciones
                    </RoundedLink>
                    <RoundedLink
                        :href="route('carritos.index')"
                        class="shadow bg-gray-100 hover:bg-gray-200">
                        <CarritoIcon class="w-4 h-4 fill-primary" />
                    </RoundedLink>
                </div>
            </h2>
        </template>
        <!-- banner section -->
        <section
            class="h-72 p-4 w-full md:h-96 flex items-center bg-alternative relative shadow md:p-8">
            <div
                class="w-[65%] md:w-[40%] absolute top-1/2 -translate-y-1/2 flex-1 flex flex-col gap-5 z-10">
                <h1 class="text-xl text-primary font-bold md:text-4xl">
                    Obtén un 30% de descuento con tu primera compra
                </h1>
                <RoundedLink
                    href="/"
                    class="bg-primary w-36 text-white font-bold hover:bg-secondary">
                    Compra Ahora
                </RoundedLink>
            </div>
            <div
                class="w-[50%] h-[70%] md:h-[95%] ml-auto rounded-md overflow-hidden">
                <div
                    class="w-full h-full relative"
                    v-if="Utilities.isLink(banner.imagen_url)"
                    :style="{
                        backgroundImage: `url('images/${banner.imagen_url}')`,
                        backgroundSize: 'cover',
                        backgroundPosition: 'center',}">
                    <h2
                        class="absolute max-w-[15rem] bottom-4 left-4 text-center font-bold text-primary bg-white text-xs md:bottom-auto md:top-4 md:text-xl md:bg-transparent">
                        {{ banner.producto.nombre_producto }} a tan solo Gs.
                        {{ banner.precio_venta }}
                    </h2>
                </div>
                <div
                    v-else
                    class="w-full h-full relative"
                    :style="{
                        backgroundImage: `url('${banner.imagen_url}')`,
                        backgroundSize: 'cover',
                        backgroundPosition: 'center',}">
                    <h2
                        class="absolute max-w-[15rem] bottom-4 left-4 text-center font-bold text-primary bg-white text-xs md:bottom-auto md:top-4 md:text-xl md:bg-transparent">
                        {{ banner.producto.nombre_producto }} a tan solo Gs.
                        {{ banner.precio_venta }}
                    </h2>
                </div>
            </div>
        </section>
        <!-- Seccion 2-->
        <section class="bg-white mt-8 pb-12 relative">
            <!-- message flash -->
            <FlashMessage :success="flashMessage" />
            <!-- Select categories -->
            <div class="h-16 flex items-center flex-wrap gap-2 md:gap-4">
                <jet-secondary-button
                    type="button"
                    @click="filterByCategories('all')"
                    :class="{ 'bg-secondary text-white': form.search === null }">
                    Todo
                </jet-secondary-button>
                <jet-secondary-button
                    @click="filterByCategories(categoria.id)"
                    type="button"
                    v-for="(categoria, index) in categorias"
                    :key="categoria.id"
                    :class="{
                        'bg-secondary text-white': form.search === categoria.id}">
                    {{ categoria.nombre_categoria }}
                </jet-secondary-button>
            </div>
            <!-- cards -->
            <transition-group
                tag="div"
                class="w-full flex flex-col justify-center items-center gap-4 md:flex-row md:flex-wrap md:justify-start md:gap-6"
                appear
                @before-enter="Animations.cardBeforeEnter"
                @enter="Animations.cardEnter">
                <template
                    v-for="(publicar, index) in publicars"
                    :key="publicar.id">
                    <Car :data-index="index">
                        <template #imagen>
                            <img
                                v-if="Utilities.isLink(publicar.imagen_url)"
                                :src="`images/${publicar.imagen_url}`"
                                :alt="publicar.imagen_url"
                                class="w-full h-full object-cover"
                            />
                            <img
                                v-else
                                src="https://media.istockphoto.com/id/1471005359/es/foto/maqueta-de-taza-de-caf%C3%A9-blanco-con-espacio-de-copia-en-blanco-en-un-podio-de-madera-sobre.jpg?s=2048x2048&w=is&k=20&c=AtBZtHbkM0ofN6ACj-GNxGcscL9GtOrxyFItY99AtGc="
                                alt="product"
                                class="w-full h-full object-cover"
                            />
                        </template>
                        <template #descripcion>
                            <div class="flex justify-between items-center">
                                <p class="font-bold capitalize">
                                    {{ publicar.producto.nombre_producto }}
                                </p>
                                <span class="font-bold">
                                    {{ publicar.precio_venta }}gs.
                                </span>
                            </div>
                            <div>
                                <p
                                    class="text-xs pt-1 pb-3 leading-4 text-gray-600">
                                    {{ publicar.detalle }}
                                </p>
                            </div>
                            <RoundedLink
                                :href="route('publicar.show', publicar.id)"
                                class="border border-primary text-sm font-bold hover:bg-primary hover:text-white">
                                Agregar al Carrito
                            </RoundedLink>
                        </template>
                    </Car>
                </template>
            </transition-group>
        </section>
    </AppLayout>
</template>
