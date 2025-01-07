<script setup lang="ts">
import AppHeader from "@/Components/AppHeader.vue";
</script>

<template>
    <AppHeader/>
    <div class="container mt-5 mx-auto">
        <slot/>
    </div>
</template>
