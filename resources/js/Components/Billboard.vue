<script setup>
import { gsap } from "gsap";
import { onMounted, ref } from "vue";

const props = defineProps({
    message: String,
});

const messageRef = ref(null);

onMounted(() => {
    if (messageRef.value) {
        const containerWidth = messageRef.value.parentElement.offsetWidth;
        const messageWidth = messageRef.value.offsetWidth;

        // Configurar la animación para moverse de izquierda a derecha
        gsap.fromTo(
            messageRef.value,
            { x: containerWidth },
            {
                x: -messageWidth,
                duration: 12, 
                ease: "linear",
                repeat: -1, 
            }
        );
    }
});
</script>

<template>
    <div
        v-if="message"
        class="h-5 w-full fixed top-0 bg-primary flex items-center overflow-hidden text-center z-50">
        <span
            ref="messageRef"
            class="text-xs font-bold text-white whitespace-nowrap">
            {{ message }}
        </span>
    </div>
</template>
