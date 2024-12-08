<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import RoundedLink from "../../Components/RoundedLink.vue";
import CarritoIcon from "../../Components/icons/CarritoIcon.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
import { watchEffect, onMounted } from "vue";
import JetButton from "@/Jetstream/Button.vue";

const props = defineProps({
    publicar: Array,
});

const form = useForm({
    cantidad: 1,
    subtotal: null,
    producto_id: props.publicar.producto.id,
});

const isLink = (stringLink) => {
    return (
        stringLink.endsWith(".png") ||
        stringLink.endsWith(".jpeg") ||
        stringLink.endsWith(".jpg")
    );
};

const guardarEnCarrito = () => {
    form.post(route("itemcarritos.store"), {
        onSuccess: () => {
            form.reset(); 
        },
    });
};

const handleButtons = (type) => {
    if (type === "minus") {
        if (form.cantidad === 1) {
            return;
        }

        form.cantidad--;
    } else if (type === "plus") {
        const stock = props.publicar.producto.stock;
        if (form.cantidad === stock) {
            return;
        }

        form.cantidad++;
    }
};

const integerToDecimal = (number) => {
    return new Intl.NumberFormat("es-ES", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    }).format(number);
};

watchEffect(() => {
    const cantidad = form.cantidad;
    const precioVenta = props.publicar.precio_venta;

    if (cantidad > 0) {
        form.subtotal = cantidad * precioVenta;
    }
});

onMounted(() => {
    const precioVenta = props.publicar.precio_venta;

    form.subtotal = precioVenta * form.cantidad;
});
</script>
<template>
    <AppLayout title="Agregar al Carrito">
        <template #header>
            <h2
                class="text-md font-medium text-primary leading-tight flex items-center flex-wrap justify-between">
                <div class="flex items-center">
                    <Link
                        :href="route('inicio.index')"
                        class="text-gray-500 hover:text-primary hover:underline">
                        Publicaciones 
                    </Link>/
                    <Link
                        :href="route('inicio.index')"
                        class="text-primary underline">
                        {{ publicar.producto.nombre_producto }} 
                    </Link>/
                </div>
                <RoundedLink
                    :href="route('carritos.index')"
                    class="shadow bg-gray-100 hover:bg-gray-200">
                    <CarritoIcon class="w-4 h-4 fill-primary" />
                </RoundedLink>
            </h2>
        </template>
        <section class="pb-12">
            <div
                class="flex flex-col gap-4 md:flex-row md:gap-8 md:items-center">
                <!-- imagen -->
                <figure
                    class="h-80 w-full border shadow rounded-md overflow-hidden max-w-2xl md:h-96">
                    <img
                        v-if="isLink(publicar.imagen_url)"
                        :src="`/images/${publicar.imagen_url}`"
                        :alt="publicar.imagen_url"
                        class="w-full h-full object-cover"
                    />
                    <img
                        v-else
                        src="https://media.istockphoto.com/id/1471005359/es/foto/maqueta-de-taza-de-caf%C3%A9-blanco-con-espacio-de-copia-en-blanco-en-un-podio-de-madera-sobre.jpg?s=2048x2048&w=is&k=20&c=AtBZtHbkM0ofN6ACj-GNxGcscL9GtOrxyFItY99AtGc="
                        alt="product"
                        class="w-full h-full object-cover"
                    />
                </figure>
                <!-- formulario -->
                <form
                    @submit.prevent="guardarEnCarrito"
                    class="flex flex-col gap-4 md:gap-6">
                    <div>
                        <h3 class="text-2xl capitalize font-medium md:text-3xl">
                            {{ publicar.producto.nombre_producto }}
                        </h3>
                        <p class="font-medium text-gray-500">
                            {{ publicar.producto.descripcion }}
                        </p>
                    </div>
                    <div class="flex gap-4">
                        <p class="text-xl font-medium">
                            {{ integerToDecimal(publicar.precio_venta) }}gs. -
                            <span class="text-gray-500 text-base">
                                {{ publicar.detalle }}
                            </span>
                        </p>
                    </div>

                    <div class="flex items-center gap-4">
                        <div
                            class="w-32 h-10 rounded-3xl overflow-hidden bg-gray-200 shadow flex">
                            <button
                                type="button"
                                @click.prevent="handleButtons('plus')"
                                class="h-full w-full text-4xl hover:bg-gray-300 text-primary">
                                +
                            </button>
                            <span
                                class="inline-block text-xl text-primary h-full pt-1">
                                {{ form.cantidad }}
                            </span>
                            <button
                                type="button"
                                @click.prevent="handleButtons('minus')"
                                class="h-full w-full text-4xl hover:bg-gray-300 text-primary">
                                -
                            </button>
                        </div>
                        <p class="text-gray-600 font-medium">
                            disponible {{ publicar.producto.stock }}
                        </p>
                    </div>
                    <p class="font-medium">
                        Total&nbsp;
                        <span class="text-gray-600">
                            {{ integerToDecimal(form.subtotal) }}gs.
                        </span>
                    </p>
                    <div class="flex gap-2">
                        <jet-button
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            type="submit">
                            Añadir al Carrito
                        </jet-button>
                    </div>
                </form>
            </div>
        </section>
    </AppLayout>
</template>
