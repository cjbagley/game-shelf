<script setup lang="ts">
import { defineProps } from 'vue';

defineProps<{
    image?: string;
    alt?: string;
    title?: string;
    buttonText?: string;
    additionalBodyClasses?: string;
}>();
</script>

<template>
    <div class="card w-96 bg-primary text-primary-content shadow-xl">
        <figure v-if="image" class="px-10 pt-10">
            <img class="rounded-xl" :src="image" :alt="alt ?? 'image'" />
        </figure>
        <div class="card-body" :class="additionalBodyClasses">
            <h2 v-if="title" class="card-title">{{ title }}</h2>
            <slot></slot>
            <div class="card-actions justify-end" v-if="buttonText">
                <button class="btn btn-primary">{{ buttonText }}</button>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
