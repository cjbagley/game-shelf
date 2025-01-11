<script setup lang="ts">
import { defineProps } from 'vue';

defineProps<{
    image?: string;
    alt?: string;
    title?: string;
    buttonText?: string;
}>();
</script>

<template>
    <div class="card w-96 bg-base-100 shadow-xl">
        <figure v-if="image">
            <img :src="image" :alt="alt ?? 'image'" />
        </figure>
        <div class="card-body">
            <h2 v-if="title" class="card-title">{{ title }}</h2>
            <slot></slot>
            <div class="card-actions justify-end" v-if="buttonText">
                <button class="btn btn-primary">{{ buttonText }}</button>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
