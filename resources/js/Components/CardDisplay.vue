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
    <div
        class="card card-compact w-72 bg-secondary text-secondary-content shadow-xl hover:cursor-pointer hover:bg-info md:w-80"
    >
        <figure v-if="image" class="pt-5">
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
