<template>
    <p class="px-3 pt-5 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider select-none">
        {{ label }}
    </p>
</template>

<script setup>
defineProps({
    label: { type: String, required: true },
})
</script>