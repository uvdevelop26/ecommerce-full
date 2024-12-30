<script setup>
defineProps({
    type: {
        type: String,
        default: "button",
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-3xl font-semibold text-xs text-gray-700 shadow-sm hover:text-white hover:bg-secondary focus:outline-none focus:bg-secondary active:text-white active:bg-secondary disabled:opacity-25 transition focus:text-white">
        <slot />
    </button>
</template>
