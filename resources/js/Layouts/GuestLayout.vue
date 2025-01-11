<script setup lang="ts">
import AppHeader from '@/Components/AppHeader.vue';
</script>

<template>
    <AppHeader />
    <div class="container mx-auto mt-5">
        <slot />
    </div>
</template>
