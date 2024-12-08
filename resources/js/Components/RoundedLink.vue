<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    href: String,
});
</script>

<template>
    <Link :href="href" class="px-5 py-2 rounded-3xl text-sm">
        <slot />
    </Link>
</template>
