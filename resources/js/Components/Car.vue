<script setup>
</script>

<template>
    <div
        class="w-full rounded-md overflow-hidden shadow bg-gray-100 max-w-[300px]">
        <figure class="h-44 w-full bg-gray-100">
            <slot name="imagen" />
           <!--  -->
        </figure>
        <div class="h-full py-8 px-4">
            <slot name="descripcion" />
            <!--  -->
        </div>
    </div>
</template>
