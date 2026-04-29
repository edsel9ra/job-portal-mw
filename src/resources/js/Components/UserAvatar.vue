<template>
    <div class="rounded-full overflow-hidden flex items-center justify-center font-bold text-white flex-shrink-0"
        :class="[sizeClasses, bgClass]">
        <img v-if="photo" :src="photoSrc" :alt="alt" class="w-full h-full object-cover" />
        <span v-else :class="textClass">
            {{ initialsText }}
        </span>
    </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    photo: {
        type: String,
        default: null,
    },
    name: {
        type: String,
        default: '',
    },
    alt: {
        type: String,
        default: 'Avatar',
    },
    size: {
        type: String,
        default: 'md', // xs, sm, md, lg, xl
    },
    bgClass: {
        type: String,
        default: 'bg-gray-900',
    },
})

const sizeMap = {
    xs: 'w-8 h-8',
    sm: 'w-10 h-10',
    md: 'w-12 h-12',
    lg: 'w-16 h-16',
    xl: 'w-20 h-20',
}

const textMap = {
    xs: 'text-xs',
    sm: 'text-xs',
    md: 'text-sm',
    lg: 'text-lg',
    xl: 'text-xl',
}

const sizeClasses = computed(() => sizeMap[props.size] ?? sizeMap.md)
const textClass = computed(() => textMap[props.size] ?? textMap.md)

const initialsText = computed(() => {
    if (!props.name) return '?'

    return props.name
        .trim()
        .split(/\s+/)
        .map(word => word[0])
        .slice(0, 2)
        .join('')
        .toUpperCase()
})

const photoSrc = computed(() => {
    if (!props.photo) return null

    if (props.photo.startsWith('http://') || props.photo.startsWith('https://') || props.photo.startsWith('/')) {
        return props.photo
    }

    return `/storage/${props.photo}`
})
</script>