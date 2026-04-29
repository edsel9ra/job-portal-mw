<script setup>
defineProps({
    checked: {
        type: [Array, Boolean],
        default: false,
    },
    value: {
        type: String,
        default: null,
    },
});

defineEmits(['update:checked']);
</script>

<template>
    <input type="checkbox" :value="value" :checked="checked" @change="$emit('update:checked', $event.target.checked)" />
</template>