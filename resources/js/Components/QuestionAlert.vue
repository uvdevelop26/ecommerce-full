<script setup>
import Modal from "./Modal.vue";
import Question from "./icons/Question.vue";

const props = defineProps({
    show: Boolean,
    question: String,
    info: String,
});

const emit = defineEmits(["close", "continues"]);

const close = () => {
  emit("close");
};

const continues = () => {
  emit("continues");
};

</script>
<template>
    <Modal :show="show" maxWidth="sm">
        <div class="w-full h-40 p-4">
            <!-- head -->
            <div class="flex items-center gap-2">
                <div
                    class="w-7 h-7 pt-2 bg-orange-600 rounded-full flex items-center justify-center">
                    <Question class="w-4 h-4 mb-2 fill-white" />
                </div>
                <p class="font-bold">{{ question }}</p>
            </div>
            <!-- info -->
            <p class="pt-3 pb-4 text-center text-sm">{{ info }}</p>
            <!-- options -->
            <div class="flex gap-4 pt-4 border-t justify-center">
                <button
                    type="button"
                    aria-label="continue"
                    class="w-20 h-8 rounded-lg text-sm text-white font-bold bg-orange-600 hover:text-orange-600 hover:bg-orange-200"
                    @click="continues">
                    Continuar
                </button>
                <button
                    type="button"
                    aria-label="close alert"
                    @click="close"
                    class="w-16 h-8 rounded-lg text-sm text-white font-bold bg-gray-400 hover:text-gray-400 hover:bg-gray-200">
                    Cerrar
                </button>
            </div>
        </div>
    </Modal>
</template>
