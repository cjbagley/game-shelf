<script setup lang="ts">
import ImagePlaceholder from './ImagePlaceholder.vue';

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
        class="card card-compact w-72 bg-primary text-primary-content shadow-xl transition duration-150 ease-in-out hover:cursor-pointer hover:bg-info md:w-80"
    >
        <figure v-if="image" class="mx-5 mt-5 h-96">
            <img class="rounded-box" :src="image" width="320" height="350" :alt="alt ?? 'image'" />
        </figure>

        <figure v-if="!image" class="mx-5 mt-5 h-96 flex-col rounded-box bg-slate-200">
            <ImagePlaceholder />
        </figure>

        <div class="card-body gap-5" :class="additionalBodyClasses">
            <h2 v-if="title" class="card-title h-12 items-start">{{ title }}</h2>
            <slot></slot>
            <div class="card-actions justify-end" v-if="buttonText">
                <button class="btn btn-primary">{{ buttonText }}</button>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
