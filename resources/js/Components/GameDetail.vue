<script setup lang="ts">
defineProps({
    label: {
        type: String,
        required: false,
        default: '',
    },
    value: {
        type: String,
        required: false,
        default: '',
    },
});
</script>

<template v-if="value">
    <div class="grid grid-cols-3 gap-1">
        <p v-if="label" class="col-span-1 text-sm font-medium text-gray-500">
            {{ label }}
        </p>
        <p class="col-span-2 text-sm text-gray-500">{{ value }}</p>
    </div>
</template>
