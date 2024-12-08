<script setup>
import { ref } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import ApplicationMark from "@/Components/ApplicationMark.vue";
import Hamburger from "../Components/icons/Hamburger.vue";
import LogoApp from "../Components/icons/LogoApp.vue";
import RoundedLink from "../Components/RoundedLink.vue";
import Search from "../Components/icons/Search.vue";
import Banner from "@/Components/Banner.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const logout = () => {
    router.post(route("logout"));
};
</script>

<template>
    <Head :title="title" />

    <div class="min-h-screen bg-white">
        <nav class="bg-white">
            <!-- promo setup -->
            <div class="h-5 w-full fixed bg-primary flex items-center text-center z-50">
                <span class="text-xs font-bold text-white">Recibe descuento con tu primera compra</span>
            </div>
            <div class="container pt-5">
                <div
                    class="h-16 flex items-center justify-between border-b border-gray-200 md:h-20 md:justify-start md:gap-8">
                    <!-- toggle button -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            @click="showingNavigationDropdown =
                                    !showingNavigationDropdown">
                            <Hamburger
                                :changePattern="showingNavigationDropdown"
                            />
                        </button>
                    </div>

                    <!-- logo -->
                    <div class="shrink-0 flex flex-col items-center gap-1">
                        <Link :href="route('inicio.index')">
                            <LogoApp class="block h-5 w-auto fill-secondary" />
                        </Link>
                        <span class="text-xs font-bold text-primary">
                            Agroagil
                        </span>
                    </div>
                    <!-- navbody desktop -->
                    <div class="hidden md:flex md:gap-4">
                        <NavLink
                            :href="route('inicio.index')"
                            :active="route().current('inicio.index')">
                            Publicaciones
                        </NavLink>
                        <NavLink
                            :href="route('categorias.index')"
                            :active="route().current('categorias.index')">
                            Categorias
                        </NavLink>
                        <!--  <NavLink
                            :href="route('ventas.index')"
                            :active="route().current('ventas.index')"
                        >
                            Ventas
                        </NavLink> -->
                        <NavLink
                            :href="route('proveedores.index')"
                            :active="route().current('proveedores.index')"
                        >
                            Proveedores
                        </NavLink>
                        <NavLink
                            :href="route('productos.index')"
                            :active="route().current('productos.index')">
                            Productos
                        </NavLink>
                     <!--    <NavLink
                            :href="route('clientes.index')"
                            :active="route().current('clientes.index')">
                            Clientes
                        </NavLink> -->
                        <NavLink
                            :href="route('carritos.index')"
                            :active="route().current('carritos.index')">
                            Carritos
                        </NavLink>
                        <NavLink
                            :href="route('datosenvio.index')"
                            :active="route().current('datosenvio.index')">
                            Envio
                        </NavLink>
                    </div>
                    <!-- search button -->
                    <div class="md:ml-auto md:flex md:items-center md:gap-2">
                        <Search class="w-auto h-5 fill-primary" />
                        <div class="hidden md:flex ml-3 relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button
                                        v-if="$page.props.jetstream.managesProfilePhotos"
                                        class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img
                                            class="h-8 w-8 rounded-full object-cover"
                                            :src="$page.props.auth.user.profile_photo_url"
                                            :alt="$page.props.auth.user.name"
                                        />
                                    </button>

                                    <span v-else class="inline-flex rounded-md">
                                        <button
                                            type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                            {{ $page.props.auth.user.name }}

                                            <svg
                                                class="ml-2 -mr-0.5 h-4 w-4"
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor">
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                                                />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <div
                                        class="block px-4 py-2 text-xs text-gray-400">
                                        Administrar Perfil
                                    </div>

                                    <DropdownLink :href="route('profile.show')">
                                        Perfil
                                    </DropdownLink>

                                    <DropdownLink
                                        v-if="$page.props.jetstream.hasApiFeatures"
                                        :href="route('api-tokens.index')">
                                        API Tokens
                                    </DropdownLink>

                                    <div class="border-t border-gray-200" />

                                    <form @submit.prevent="logout">
                                        <DropdownLink as="button">
                                            Cerrar Sesión
                                        </DropdownLink>
                                    </form>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                </div>
                <!-- navbody movile -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,}"
                    class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('inicio.index')"
                            :active="route().current('inicio.index')">
                            Inicio
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('proveedores.index')"
                            :active="route().current('proveedores.index')">
                            Proveedores
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('categorias.index')"
                            :active="route().current('categorias.index')">
                            Categorias
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('productos.index')"
                            :active="route().current('productos.index')">
                            Productos
                        </ResponsiveNavLink>
                    </div>

                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div
                                v-if="$page.props.jetstream.managesProfilePhotos"
                                class="shrink-0 mr-3">
                                <img
                                    class="h-10 w-10 rounded-full object-cover"
                                    :src="$page.props.auth.user.profile_photo_url"
                                    :alt="$page.props.auth.user.name"
                                />
                            </div>
                            <div>
                                <div
                                    class="font-medium text-base text-gray-800">
                                    {{ $page.props.auth.user.name }}
                                </div>
                                <div class="font-medium text-sm text-gray-500">
                                    {{ $page.props.auth.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink
                                :href="route('profile.show')"
                                :active="route().current('profile.show')">
                                Profile
                            </ResponsiveNavLink>

                            <ResponsiveNavLink
                                v-if="$page.props.jetstream.hasApiFeatures"
                                :href="route('api-tokens.index')"
                                :active="route().current('api-tokens.index')">
                                API Tokens
                            </ResponsiveNavLink>

                            <form method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink as="button">
                                    Log Out
                                </ResponsiveNavLink>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

          <!--    Page Heading -->
        <header v-if="$slots.header" class="bg-white">
            <div class="container py-6 px-4 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>

        <!--  Page Content -->
        <main class="container">
            <slot />
        </main>
    </div>
</template>
