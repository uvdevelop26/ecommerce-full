<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import CarritoIcon from "../../Components/icons/CarritoIcon.vue";
import RoundedLink from "../../Components/RoundedLink.vue";
import Car from "../../Components/Car.vue";
import { Inertia } from "@inertiajs/inertia";
import { Link } from "@inertiajs/inertia-vue3";
import JetButton from "@/Jetstream/Button.vue";

const props = defineProps({
    publicars: Array,
});

const isLink = (stringLink) => {
    return (
        stringLink.endsWith(".png") ||
        stringLink.endsWith(".jpeg") ||
        stringLink.endsWith(".jpg")
    );
};


</script>

<template>
    <AppLayout title="Listado de Publicaciones">
        <!-- Encabezado -->
        <template #header>
            <h2
                class="text-md font-bold text-primary leading-tight flex items-center flex-wrap justify-between">
                Últimas Publicaciones
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

        <!-- <section class="h-48 bg-hero-banner bg-cover bg-center bg-no-repeat">
            <div class=""></div>
            <RoundedLink
                href="/"
                class="absolute left-2 bottom-4 z-50 bg-primary text-white italic hover:bg-secondary"
            >
                Comprar Ahora
            </RoundedLink> 
        </section> -->
        <!-- Seccion 2-->
        <section
            class="bg-white pb-12 flex flex-col gap-4 md:flex-row md:flex-wrap md:justify-star">
            <Car v-for="publicar in publicars" :key="publicar.id">
                <template #imagen>
                    <img
                        v-if="isLink(publicar.imagen_url)"
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
                    <p class="text-xs pt-1 pb-3 leading-4 text-gray-600">
                        {{ publicar.detalle }}
                    </p>
                    <RoundedLink
                        :href="route('publicar.show', publicar.id)"
                        class="border border-primary text-sm font-bold hover:bg-primary hover:text-white">
                        Agregar al Carrito
                    </RoundedLink>
                </template>
            </Car>
        </section>
    </AppLayout>
</template>
