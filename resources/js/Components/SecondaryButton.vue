<script setup lang="ts">
withDefaults(
    defineProps<{
        type?: 'button' | 'submit' | 'reset';
    }>(),
    {
        type: 'button',
    },
);
</script>

<template>
    <button :type="type" class="btn btn-secondary rounded-btn">
        <slot />
    </button>
</template>
