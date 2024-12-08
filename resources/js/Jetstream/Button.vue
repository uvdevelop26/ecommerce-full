<script setup>
defineProps({
    type: {
        type: String,
        default: "submit",
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center px-5 py-2 bg-gray-100 border-primary rounded-3xl font-semibold text-xs border text-primary hover:bg-primary hover:text-white active:bg-primary focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
        <slot />
    </button>
</template>
