<script setup>
const props = defineProps({
    success: String,
});
</script>

<template>
    <transition name="flash">
        <div
            class="bg-secondary h-14 w-full max-w-xs rounded-md absolute -top-16 left-1/2 -translate-x-1/2"
            v-if="success">
            <div
                class="flex items-center justify-center w-full h-full text-white text-sm font-bold italic">
                {{ success }}
            </div>
        </div>
    </transition>
</template>
<style scoped>
.flash-enter-from,
.flash-leave-to {
    opacity: 0;
    transform: translateY(-60px); /* Solo movimiento vertical */
}

.flash-enter-to,
.flash-leave-from {
    opacity: 1;
    transform: translateY(0); /* Posición final */
}

.flash-enter-active,
.flash-leave-active {
    transition: opacity 0.5s ease, transform 0.5s ease; /* Solo transiciones relevantes */
}
</style>
